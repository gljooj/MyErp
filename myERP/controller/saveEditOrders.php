<?php
$id = $_POST['id'];
$user = $_POST['user'];
require_once('../Classes/dataBase.php');
$dataBase = new dataBase();

$query = "SELECT id,username FROM users where id = {$id} and username = '{$user}'";
$exist = $dataBase->select($query);

if ($exist) {
    $query = "SELECT id,sku,name,price,stock from products";
    $products = $dataBase->select($query);
    if ($_POST['action'] == 'Salvar') {
        $message['error'] = [];
        $message['success'] = [];
        $message['noDatas'] = [];
        $editedOrders = $_POST['arrayOrders'];
        $n = 0;
        $e = 0;
        foreach ($editedOrders as $product) {
            $verifyQuery = "SELECT * FROM order_items 
                            WHERE order_id = {$product['order_id']} 
                            AND id = {$product['item_id']}
                            AND qty = '{$product['qty']}'
                            AND price = '{$product['price']}'";
            $verify = $dataBase->select($verifyQuery);
            
            if (!$verify && $verify == null) {
                $total = $product['qty'] *$product['price'];
                $verifyQueryItem = "SELECT * FROM order_items 
                                WHERE order_id = {$product['order_id']} 
                                AND id = {$product['item_id']}";
                $verifyItem = $dataBase->select($verifyQueryItem);
                if($product['qty'] != $verifyItem['dados'][0]['qty']){
                    if($product['qty'] > $verifyItem['dados'][0]['qty']){
                        $calcStock =  "{$product['qty']}" - $verifyItem['dados'][0]['qty'];
                        $typeCalc = '-';
                    }else{
                        $calcStock =  $verifyItem['dados'][0]['qty'] - "{$product['qty']}";
                        $typeCalc = '+';
                    }
                    if($typeCalc == '-'){
                        $verifyStockQuery = "SELECT * FROM products where sku = '{$product['sku']}' and stock >= '{$calcStock}'";
                        $verifyStock = $dataBase->select($verifyStockQuery);    
                    }else{
                        $verifyStock = true;
                    }
                    
                    $difStock = 1;
                }
                if(isset($difStock) && !$verifyStock){
                    $e++;
                    $message['error'][$e] = 'Produto ' . $product['sku'].' do pedido de id '.$product['order_id']. 'Estoque menor do que o solicitado';    
                    continue;
                }
                
                
                $queryToUpdate = "UPDATE order_items set
                qty = {$product['qty']},
                price = {$product['price']},
                total_value = '{$total}'
                WHERE order_id = {$product['order_id']} AND id = {$product['item_id']}";

                $update = $dataBase->update($queryToUpdate);
                if ($update) {
                    $message['success'][$n] = 'Produto ' . $product['sku'] . ' do pedido de id '.$product['order_id']. ' Atualizado com Sucesso';
                    $n++;
                    if(isset($difStock)){
                        $downStockQuery = "UPDATE products set stock = (stock {$typeCalc} $calcStock) where sku = '{$product['sku']}'";
                        $downStock = $dataBase->update($downStockQuery);
                        if($downStock){
                            $message['success'][$n] = 'Item: ' . $product['sku'] . ' Baixado Estoque com Sucesso';
                            $n++;
                        }else{
                            $message['error'][$n] = 'Item: ' . $product['sku'] . ' Erro ao baixar Estoque';
                            $e++;
                        }
                    }
                } else {
                    $e++;
                    $message['error'][$e] = 'Erro ao atualizar produto ' . $product['sku'].' do pedido de id '.$product['order_id'];
                }
                $messageFlag = 1;    
            }
        }
        if (!isset($messageFlag)) {
            $message['noDatas'][0] = 'Não há dados para atualizar';
        }
        $json_str = json_encode($message);
        return header('Location: ../view/Pedidos.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
    }
    elseif($_POST['action'] == 'Cadastrar'){
        $message['error'] = [];
        $message['success'] = [];
        $message['noDatas'] = [];
        $n = 0;
        $e = 0;
        $save['sku'] = isset($_POST['sku']) && $_POST['sku'] != '' ? $_POST['sku'] : $message['error'][$e++] = "Dado sku não informado {$_POST['sku']}";
        $save['qty'] = isset($_POST['qty']) && $_POST['qty'] != '' ? $_POST['qty'] :  $message['error'][$e++] = "Dado qty  não informado {$_POST['qty']}";
        $save['price'] = isset($_POST['price']) && $_POST['price'] != '' ? $_POST['price'] :  $message['error'][$e++] = "Dado price não informado {$_POST['price']}";
        $save['number_order'] = isset($_POST['number_order']) && $_POST['number_order'] != '' ? $_POST['number_order'] :  $message['error'][$e++] = "Dado número de pedido não informado {$_POST['number_order']}";
        $save['origin'] = isset($_POST['origin']) && $_POST['origin'] != '' ? $_POST['origin'] :  $message['error'][$e++] = "Dado origin não informado {$_POST['number_order']}";
        $save['customer_id'] = isset($_POST['customer_id']) && $_POST['customer_id'] != '' ? $_POST['customer_id'] :  $message['error'][$e++] = "Dado cliente_id não informado {$_POST['number_order']}";
        
        if(isset($message['error'][0])){
            
            $json_str = json_encode($message);
            return header('Location: ../view/Pedidos.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
        }
        
            $verifyQuery = "SELECT * FROM orders 
                            WHERE number_order = {$save['number_order']} and origin = '{$save['origin']}' and customer_id = '{$save['customer_id']}'";
            $verify = $dataBase->select($verifyQuery);
            
            if (!$verify && $verify == null) {
                $total = $save['price']*$save['qty'];
                if($total == 0){
                    $e++;
                    $message['error'][$e] = 'Erro ao Atualizar items do Pedido ' . $save['number_order'] . 'Valor total de item = 0';   
                }else{
                    
                    $verifyStockQuery = "SELECT * FROM products where sku = '{$save['sku']}' and stock >= '{$save['qty']}'";
                    $verifyStock = $dataBase->select($verifyStockQuery);
                    
                    if(!$verifyStock){
                        $e++;
                        $message['error'][$e] = 'Produto ' . $save['sku'].' do pedido de id '.$save['order_id']. 'Estoque menor do que o solicitado';    
                    }
                    else{
                        $queryToInsertOrder = "INSERT INTO myCommerce.orders
                        (number_order,origin,customer_id,total_value,creat_at)
                        VALUES('{$save['number_order']}', '{$save['origin']}', '{$save['customer_id']}',
                        '{$total}', now())";
                    
                        $insertOrder = $dataBase->insert($queryToInsertOrder);
                        if ($insertOrder) {
                            $message['success'][$n] = 'Pedido ' . $save['number_order'] . ' Criado com Sucesso';
                            $n++;
                            
                            $getId = "SELECT * FROM orders 
                                    WHERE number_order = {$save['number_order']}";
                            $getId = $dataBase->select($verifyQuery);
                            $order_id = $getId['dados'][0]['id'];
    
                            $queryToInsertItem = "INSERT INTO myCommerce.order_items
                            (order_id,sku,qty,price,total_value,creat_at)
                            VALUES('{$order_id}', '{$save['sku']}', '{$save['qty']}','{$save['price']}','{$total}', now())";
                            $insertOrderItem = $dataBase->insert($queryToInsertItem);

                            if ($insertOrderItem) {
                                $message['success'][$n] = 'Items do pedido ' . $save['number_order'] . ' Inserido com Sucesso';
                                $n++;
                                $downStockQuery = "UPDATE products set stock =(stock - '{$save['qty']}') where sku = '{$save['sku']}'";
                                $downStock = $dataBase->update($downStockQuery);

                                if($downStock){
                                    $message['success'][$n] = 'Item: ' . $save['sku'] . ' Baixado Estoque com Sucesso';
                                    $n++;
                                }else{
                                    $message['error'][$n] = 'Item: ' . $save['sku'] . ' Erro ao baixar Estoque';
                                    $e++;
                                }
                            }else{
                                $e++;
                                $message['error'][$e] = 'Erro ao inserir items do Pedido ' . $save['number_order'];    
                            }
    
                        } else {
                            $e++;
                            $message['error'][$e] = 'Erro ao Criar Pedido ' . $save['number_order'];
                        }
                        $messageFlag = 1;
                        
                    }    
                }
                
            }else{
                $order_id = $verify['dados'][0]['id'];
                $total = $save['price'] * $save['qty'];
                if($total == 0){
                    $e++;
                    $message['error'][$e] = 'Erro ao Atualizar items do Pedido ' . $save['number_order'] . 'Valor total de item = 0';   
                }else{

                    $verifyStock = "SELECT * FROM products where sku = '{$product['sku']}' and stock >= '{$product['qty']}'";
                    $verifyStock = $dataBase->select($verifyQuery);
            
                    if(!$verifyStock){
                        $e++;
                        $message['error'][$e] = 'Produto ' . $product['sku'].' do pedido de id '.$product['order_id']. 'Estoque menor do que o solicitado';
                    }else{
                        $verifyItemQuery = "SELECT * FROM order_items 
                        WHERE sku = '{$save['sku']}' and order_id = '{$order_id}'";
                    
                        $verifyItem = $dataBase->select($verifyItemQuery);
        
                        if($verifyItem){
                            $queryToInsertItem = "UPDATE myCommerce.order_items
                            SET qty =  '{$save['qty']}', price = '{$save['price']}',total_value = '{$total}'
                            WHERE sku = '{$save['sku']}'";
                            
                            $insertOrderItem = $dataBase->insert($queryToInsertItem);
                            if ($insertOrderItem) {
                                $message['success'][$n] = 'Items do pedido ' . $save['number_order'] . ' Atualizado com Sucesso';
                                $n++;
                                $downStockQuery = "UPDATE products set stock = (stock - {$save['qty']}) where sku = '{$save['sku']}'";
                                $downStock = $dataBase->select($downStockQuery);
                                if($downStock){
                                    $message['success'][$n] = 'Item: ' . $save['sku'] . ' Baixado Estoque com Sucesso';
                                    $n++;
                                }else{
                                    $message['error'][$n] = 'Item: ' . $save['sku'] . ' Erro ao baixar Estoque';
                                    $e++;
                                }
                            }else{
                                $e++;
                                $message['error'][$e] = 'Erro ao Atualizar items do Pedido ' . $save['number_order'];    
                            }
                        }else{
                            $queryToInsertItem = "INSERT INTO myCommerce.order_items
                            (order_id,sku,qty,price,total_value,creat_at)
                            VALUES('{$order_id}', '{$save['sku']}', '{$save['qty']}','{$save['price']}','{$total}', now())";
                            $insertOrderItem = $dataBase->insert($queryToInsertItem);
                            if ($insertOrderItem) {
                                $message['success'][$n] = 'Items do pedido ' . $save['number_order'] . ' Inserido com Sucesso';
                                $n++;
                            
                            }else{
                                $e++;
                                $message['error'][$e] = 'Erro ao inserir items do Pedido ' . $save['number_order'];    
                            }
                        }
                    }
                }
            }
        if (!isset($messageFlag)) {
            $message['noDatas'][0] = 'Não há dados para inserir';
        }
        $json_str = json_encode($message);
        return header('Location: ../view/Pedidos.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
    } else {
        return header('Location: ../view/Pedidos.php?id=' . $id . '&user=' . $user);
    }
} else {
    return header('Location: index.php?login=erro');
}
