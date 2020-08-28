<?php
$id = $_POST['id'];
$user = $_POST['user'];


require_once('../Classes/dataBase.php');
$dataBase = new dataBase();

$query = "SELECT id,username FROM users where id = {$id} and username = '{$user}'";
$exist = $dataBase->select($query);

if ($exist) {
    $query = "SELECT id,name,document from customers";
    $customers = $dataBase->select($query);
?>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Editar Clientes</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    </head>
    <div class="jumbotron">
        <h3 style="font-style:oblique; font-weight:bold; font-size:200%; position:center; text-align:center; font-family: 'Open Sans';"> Editar Clientes </h3>

    </div>
    <div>
        <form action="Customers.php" method="get">
            <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
            <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />

            <input type="submit" value="Clientes" class="btn btn-primary" style="position:absolute; 
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
                            <form action="../controller/saveEditCustomers.php" method="post">
                                <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
                                <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />
                                <div style="position:relative; left:37%;">
                                    
                                    <table style="width:500px; position:relative; right:15%;" border=1>
                                        <thead class="bg-primary" align="left" style="display: table-header-group">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Documento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($customers)) {
                                                $customers = $customers['dados'];
                                                $count = 0;
                                                foreach ($customers as $rows) : ?>
                                                    <tr class="item_row" height=40>
                                                        <td><?php echo $rows['id']; ?></td>
                                                        <input name="arrayCustomers[<?php echo $count; ?>][id]" value="<?php echo $rows['id']; ?>" style="visibility:hidden; font-size: 2px;  position:relative;" />
                                                        <td><input type="text" size="40" name="arrayCustomers[<?php echo $count; ?>][name]" value="<?php echo $rows['name'];  ?>" style="position: relative;" /></td>
                                                        <td><input type="float" size="20" name="arrayCustomers[<?php echo $count; ?>][document]" value="<?php echo $rows['document']; ?>" style="position: relative;" /></td>
                                                        <?php $count++; ?>
                                                    </tr>
                                                    
                                                <?php endforeach; ?>
                                                <input type="submit"  name="action" value="Salvar" class="btn btn-primary" style="position:relative; top:110px; left:34%">
                                                
                                            <?php } else { ?>
                                                <td> Sem </td>
                                                <td> dados</td>
                                                <td> cadastrados</td>
                                            <?php } ?>
                                        </tbody>
                                    </table> 
                                </div>
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