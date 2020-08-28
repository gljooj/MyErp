<?php
var_dump('oi');die;
require_once('../Classes/dataBase.php');
$dataBase = new dataBase();
$sku = $_REQUEST['sku'];
$query = "SELECT * FROM products where sku = '{$sku}'";
$exist = $dataBase->select($query);
var_dump($exist);die;
echo json_encode($exist['dados']['0']['price']);