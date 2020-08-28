<?php
$id = $_POST['id'];
$user = $_POST['user'];
require_once('../Classes/dataBase.php');
$dataBase = new dataBase();

$query = "SELECT id,username FROM users where id = {$id} and username = '{$user}'";
$exist = $dataBase->select($query);

if ($exist) {
    $query = "SELECT id,document from customers";
    $products = $dataBase->select($query);
    if ($_POST['action'] == 'Salvar') {
        $message['error'] = [];
        $message['success'] = [];
        $message['noDatas'] = [];
        $messageFlag = 0;
        $editedCustomers = $_POST['arrayCustomers'];
        $n = 0;
        $e = 0;
        foreach ($editedCustomers as $customer) {
            
            $verifyQuery = "SELECT * FROM customers 
                            WHERE id = {$customer['id']} 
                            AND name = '{$customer['name']}'
                            AND document = '{$customer['document']}'";
            $verify = $dataBase->select($verifyQuery);

            if (!$verify && $verify == null) {
                $queryToUpdate = "UPDATE customers set name = '{$customer['name']}',
                document = '{$customer['document']}'
                WHERE id = {$customer['id']}";
                $update = $dataBase->update($queryToUpdate);
                if ($update) {
                    $message['success'][$n] = 'Cliente ' . $product['document'] . ' Atualizado com Sucesso';
                    $n++;
                } else {
                    $e++;
                    $message['error'][$e] = 'Erro ao atualizar cliente ' . $product['document'];
                }
                $messageFlag = 1;
            }
        }
        if ($messageFlag == 0) {
            $message['noDatas'][0] = 'Não há dados para atualizar';
        }
        $json_str = json_encode($message);
        return header('Location: ../view/Customers.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
    }
    elseif($_POST['action'] == 'Cadastrar'){
        $message['error'] = [];
        $message['success'] = [];
        $message['noDatas'] = [];
        $messageFlag = 0;
        $n = 0;
        $e = 0;
        $save['name'] = isset($_POST['name']) && $_POST['name'] != '' ? $_POST['name'] :  $message['error'][$e++] = "Dado name  não informado {$_POST['name']}";
        $save['document'] = isset($_POST['document']) && $_POST['document'] != '' ? $_POST['document'] : $message['error'][$e++] = "Dado documento não informado {$_POST['document']}";
        
        if(isset($message['error'][0])){
            
            $json_str = json_encode($message);
            return header('Location: ../view/Customers.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
        }
        
            $verifyQuery = "SELECT * FROM customers 
                            WHERE document = {$save['document']}";
            $verify = $dataBase->select($verifyQuery);
            if (!$verify && $verify == null) {
                
                $queryToInsert = "INSERT INTO myCommerce.customers
                (name, document)
                VALUES('{$save['name']}', 
                '{$save['document']}')";
                $insert = $dataBase->insert($queryToInsert);
                if ($insert) {
                    $message['success'][$n] = 'Cliente ' . $save['name'] . ' Inserido com Sucesso';
                    $n++;
                } else {
                    $e++;
                    $message['error'][$e] = 'Erro ao inserir Cliente ' . $save['sku'];
                }
                $messageFlag = 1;
            }else{
                $e++;
                $message['error'][$e] = 'Cliente já existe na base ' . $save['sku'];
            }
        if ($messageFlag == 0) {
            $message['noDatas'][0] = 'Não há dados para inserir';
        }
        $json_str = json_encode($message);
        return header('Location: ../view/Customers.php?id=' . $id . '&user=' . $user . '&message=' . $json_str);
    } else {
        return header('Location: ../view/Customers.php?id=' . $id . '&user=' . $user);
    }
} else {
    return header('Location: index.php?login=erro');
}
?>
