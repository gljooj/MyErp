<?php
$id = $_GET['id'];
$user = $_GET['user'];
if (isset($_GET['message'])){
    $code = json_decode($_GET['message']);
}   
require_once('../Classes/dataBase.php');
$dataBase = new dataBase();
$query = "SELECT id,username FROM users where id = {$id} and username = '{$user}'";
$exist = $dataBase->select($query);

if ($exist) {
    if(isset($_GET['condition'])){
        
        $query = "SELECT id,sku,name,price,stock from products where id	like '%{$_GET['condition']}%'
        or sku like '%{$_GET['condition']}%'
        or name like '%{$_GET['condition']}%'
        or description like '%{$_GET['condition']}%' 
        or price like '%{$_GET['condition']}%'
        or stock like '%{$_GET['condition']}%' ";
        $showall = 1;
    }else{
        $query = "SELECT id,sku,name,price,stock from products";
    }
    
    $products = $dataBase->select($query);
?>
   
<html>
<title>Produtos</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

<div class="col-md-12">
    <div class="jumbotron">
        <h3 style="font-style:oblique; font-weight:bold; font-size:200%; position:center; text-align:center; font-family: 'Open Sans';"> Produtos </h3>

    </div>
</div>

<?php 
            if (isset($code->error)) {
                $messageError = $code->error;
                foreach ($messageError as $message): ?>
                    <div  style="
                        background: red">
                        <p><?php echo $message ?></p>
                    </div>
                <?php endforeach; ?>

            <?php } ?>
            
            <?php 
            if (isset($code->success)) {
                $messageSuccess = $code->success;
                foreach ($messageSuccess as $message): ?>
                    <div style="
                        background-color: blue; color:white">
                        <p><?php echo $message ?></p>
                    </div>
                <?php endforeach; ?>

            <?php } ?>


            <?php 
            if (isset($code->noDatas[0])) {
                $message = $code->noDatas[0]; ?>
                    <div class="notification">
                        <p><?php echo $message ?></p>
                    </div>
                
            <?php } ?>

  
<form action="menu.php" method="get">
            <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
            <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />
            <input type="submit" class = "btn btn-primary" value="Menu" style="position:absolute; 
                right:1%;
                font-size: 15px;
                font-family: 'Open Sans'">
            </input>
        </form>


<div class="col-md-3">
    <p style="font-family: 'Open Sans' "> Pesquisar </p>
    
    <form action="Pesquisar.php" method="get" >
        <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
        <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />
                        
        <input class="form-control" type="text" style="font-family: 'Open Sans'"  name="value"  placeholder="Pesquisar..." id="txtPesquisar" style="position:relative;left:10%" required />
        <input type="submit" name="action" value="Pesquisar Produto" style="position:relative;left:110%; top: -38px" class="btn btn-primary" >
                                    
    </form>
</div>
<hr />

<div class="container" style="font-family: 'Open Sans';">
    <div class="label">
        <div class="col-md-12">
            <table class="table">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col">Sku</th>
                        <th scope="col">Nome do produto</th>
                        <th scope="col">Valor do Produto</th>
                        <th scope="col">Estoque</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                            if(isset($products)){
                                $products = $products['dados'];
                                foreach ($products as $rows) : ?>
                                <tr>
                                    <td> <?php echo $rows['sku']; ?></td>
                                    <td> <?php echo $rows['name']; ?></td>
                                    <td> <?php echo $rows['price']; ?></td>
                                    <td> <?php echo $rows['stock']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php }else{?>
                                <td> Sem </td>
                                <td> dados</td>
                                <td> cadastrados</td>
                            <?php } ?>
                    </tbody>
            </table>

            <form action="registerProduct.php" method="post">                
                    <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
                    <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />
                    <td> <input type="submit" class="btn btn-primary" name = "action" id="btnRegistrarProd" style="float:right; " value="Cadastrar Produto" /></td>
            </form>

            <form action="editProduct.php" method="post">                
                    <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
                    <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />
                        <td> <input type="submit" class="btn btn-primary" name = "action" value ="Editar"  /></td>
                    </form>
                
            <!-- <button type="button" class="btn btn-primary" style="position:center">Registrar Produto</button> -->
            <?php 
            if (isset($showall)) { ?>
                <form action="Produtos.php" method="get">
                    <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
                    <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />

                    <input type="submit" value="Mostrar Produtos" class="btn btn-primary" style="position:relative; 
                            top:2%;
                            left:86%;
                            font-size: 15px;">
                    </input>
                </form>
            <?php } ?>

        </div>
    </div>
</div>

</html>
<?php
} else {
    return header('Location: index.php?login=erro');

}

?>