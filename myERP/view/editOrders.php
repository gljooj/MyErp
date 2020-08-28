<?php
$id = $_POST['id'];
$user = $_POST['user'];


require_once('../Classes/dataBase.php');
$dataBase = new dataBase();

$query = "SELECT id,username FROM users where id = {$id} and username = '{$user}'";
$exist = $dataBase->select($query);

if ($exist) {
    $query = "SELECT order_id,i.id as item_id, number_order,origin, customer_id,sku,qty,price from orders as o
            INNER JOIN order_items as i
            ON o.id = i.order_id";
    $orders = $dataBase->select($query);
?>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Editar Pedido</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    </head>
    <div class="jumbotron">
        <h3 style="font-style:oblique; font-weight:bold; font-size:200%; position:center; text-align:center; font-family: 'Open Sans';"> Editar Pedido </h3>

    </div>
    <div>
        <form action="Pedidos.php" method="get">
            <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
            <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />

            <input type="submit" value="Pedidos" class="btn btn-primary" style="position:absolute; 
                        top:2%;
                        left:92%;
                        font-size: 15px;">
            </input>
        </form>
        <form action="menu.php" method="get">
            <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
            <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />
            <button class="btn btn-primary" type="submit" style="position:absolute; 
                        top:2%;
                        right:94%;
                        font-size: 15px;">Menu
            </button>
        </form>
    </div>

    <body>
        <section class="hero is-success is-fullheight">
            <div class="hero-body">

                <div class="container" style="font-family: 'Open Sans';">
                    <div class="label">
                        <div class="col-md-12">
                            <form action="../controller/saveEditOrders.php" method="post">
                                <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
                                <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />

                                <table style="width:500px; position:relative; left:20%;" border=1>
                                    <thead class="bg-primary" align="left" style="display: table-header-group">
                                        <tr>
                                            <th scope="col">Número do pedido</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Cliente_id</th>
                                            <th scope="col">Sku</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($orders)) {
                                            $count = 0;
                                            $orders = $orders['dados'];
                                            foreach ($orders as $rows) :
                                        ?>
                                                <input name="arrayOrders[<?php echo $count; ?>][order_id]" value="<?php echo $rows['order_id']; ?>" style="visibility:hidden; font-size: 2px;  position:relative;" />
                                                <input name="arrayOrders[<?php echo $count; ?>][item_id]" value="<?php echo $rows['item_id']; ?>" style="visibility:hidden; font-size: 2px;  position:relative;" />
                                                <input name="arrayOrders[<?php echo $count; ?>][sku]" value="<?php echo $rows['sku']; ?>" style="visibility:hidden; font-size: 2px;  position:relative;" />

                                                <tr class="item_row" height=40>
                                                    <td><?php echo $rows['number_order']; ?></td>
                                                    <td><?php echo $rows['origin']; ?></td>
                                                    <td><?php echo $rows['customer_id']; ?></td>
                                                    <td><?php echo $rows['sku']; ?></td>
                                                    <td><input name="arrayOrders[<?php echo $count; ?>][qty]" value="<?php echo $rows['qty']; ?>" /></td>
                                                    <td><input name="arrayOrders[<?php echo $count; ?>][price]" value="<?php echo $rows['price']; ?>" /></td>
                                                    <?php $count++; ?>
                                                </tr>

                                            <?php endforeach; ?>
                                            <input type="submit" name="action" value="Salvar" class="btn btn-primary" style="position:relative;top:20%;">

                                        <?php } else { ?>
                                            <td> Sem </td>
                                            <td> dados</td>
                                            <td> cadastrados</td>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </section>

    </body>

    </html>
<?php
} else {
    return header('Location: index.php?login=erro');
}

?>