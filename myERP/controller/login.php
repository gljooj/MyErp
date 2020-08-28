<?php
ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');
echo "<pre>";
require_once('../Classes/dataBase.php');

$dataBase = new dataBase();

if(isset($_POST['emailLogin'])){
    var_dump($_POST);

    $query = "SELECT * FROM users where email = '{$_POST['emailLogin']}' AND password = '{$_POST['passwordLogin']}' limit 1";
    
    $login = $dataBase->select($query);
    
    if($login){
        $id = $login['dados'][0]['id'];
        $user = $login['dados'][0]['username'];
        return header('Location: ../view/menu.php?id='.$id.'&user='.$user);
    }else{
        return header('Location: ../index.php?login=erro');
    }

}else{
    return header('Location: ../index.php?login=erro');
}

?>