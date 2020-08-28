<?php
$id = $_POST['id'];
$user = $_POST['user'];
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'Pedidos':
            return header('Location: ../view/Pedidos.php?id='.$id.'&user='.$user);
            break;
        case 'Clientes':
            return header('Location: ../view/Customers.php?id='.$id.'&user='.$user);
            break;
        case 'Produtos':
            return header('Location: ../view/Produtos.php?id='.$id.'&user='.$user);
            break;
        default:
            return header('Location: ../view/menu.php?id='.$id.'&user='.$user);
            break;
    }
} else {
    echo 'erro ao solicitar pagina';
    sleep(1);
    return header('Location: ../view/menu.php?id='.$id.'&user='.$user);
}
