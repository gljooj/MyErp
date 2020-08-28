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
        $messageFlag = 0;
        $editedProducts = $_POST['arrayProducts'];
        $n = 0;
        $e = 0;
        foreach ($editedProducts as $product) {
            $verifyQuery = "SELECT * FROM products 
                            WHERE id = {$product['id']} 
                            AND name = '{$product['name']}' 
                            AND price = {$product['price']}
                            AND stock = {$product['stock']}";
            $verify = $dataBase->select($verifyQuery);
            if (!$verify && $verify == null) {
                $queryToUpdate = "UPDATE products set name = '{$product['name']}',
                price = {$product['price']},
                stock = {$product['stock']}
                WHERE id = {$product['id']}";
                $update = $dataBase->update($queryToUpdate);
                if ($update) {
                    $message['success'][$n] = 'Produto ' . $product['sku'] . ' Atualizado com Sucesso';
                    $n++;
                } else {
                    $e++;
                    $message['error'][$e] = 'Erro ao atualizar produto ' . $product['sku'];
                }
                $messageFlag = 1;
            }
        }
        if ($messageFlag == 0) {
            $message['noDatas'][0] = 'Não há dados para atualizar';
        }
        $json_str = json_encode($message);
        return header('Location: ../view/Produtos.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
    }
    elseif($_POST['action'] == 'Cadastrar'){
        $message['error'] = [];
        $message['success'] = [];
        $message['noDatas'] = [];
        $messageFlag = 0;
        $n = 0;
        $e = 0;
        $save['sku'] = isset($_POST['sku']) && $_POST['sku'] != '' ? $_POST['sku'] : $message['error'][$e++] = "Dado sku não informado {$_POST['sku']}";
        $save['name'] = isset($_POST['name']) && $_POST['name'] != '' ? $_POST['name'] :  $message['error'][$e++] = "Dado name  não informado {$_POST['name']}";
        $save['desc'] = isset($_POST['desc']) && $_POST['desc'] != '' ? $_POST['desc'] :  '';
        
        $save['price'] = isset($_POST['price']) && $_POST['price'] != '' ? $_POST['price'] :  $message['error'][$e++] = "Dado price não informado {$_POST['price']}";
        $save['stock'] = isset($_POST['stock']) && $_POST['stock'] != '' ? $_POST['stock'] :  $message['error'][$e++] = "Dado stock não informado {$_POST['stock']}";

        if(isset($message['error'][0])){
            
            $json_str = json_encode($message);
            return header('Location: ../view/Produtos.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
        }
        
            $verifyQuery = "SELECT * FROM products 
                            WHERE sku = '{$save['sku']}'";
            $verify = $dataBase->select($verifyQuery);
            if (!$verify && $verify == null) {
                
                $queryToInsert = "INSERT INTO myCommerce.products
                (sku, name, description, price, stock)
                VALUES('{$save['sku']}', '{$save['name']}', 
                '{$save['desc']}', '{$save['price']}', '{$save['stock']}')";

                $insert = $dataBase->insert($queryToInsert);
                if ($insert) {
                    $message['success'][$n] = 'Produto ' . $save['sku'] . ' Inserido com Sucesso';
                    $n++;
                } else {
                    $e++;
                    $message['error'][$e] = 'Erro ao inserir produto ' . $save['sku'];
                }
                $messageFlag = 1;
            }else{
                $e++;
                $message['error'][$e] = 'Produto já existe na base ' . $save['sku'];
            }
        if ($messageFlag == 0) {
            $message['noDatas'][0] = 'Não há dados para inserir';
        }
        $json_str = json_encode($message);
        return header('Location: ../view/Produtos.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
    } else {
        return header('Location: ../view/Produtos.php?id=' . $id . '&user=' . $user);
    }
} else {
    return header('Location: index.php?login=erro');
}
?>