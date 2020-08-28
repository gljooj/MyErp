    <?php
    $id = $_GET['id'];
    $user = $_GET['user'];
    $query = "SELECT id,username FROM users where id = {$id} and username = '{$user}'";
    require_once('../Classes/dataBase.php');
    $dataBase = new dataBase();
    $exist = $dataBase->select($query);

    if($exist){?>
        <html>
      
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Menu</title>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
            <link rel="stylesheet" href="../css/bulma.min.css" />
            <link rel="stylesheet" type="text/css" href="../css/login.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        </head>
        
            <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-blue"  style="color: black;">MyERP</h3>
            </div>
        </div>
        <div>
            
         <form action="../index.php" method="get">
                <input name="id" value="<?php echo $id; ?>" style="visibility:hidden; font-size: 2px; position:absolute; " />
                <input name="user" value="<?php echo $user; ?>" style="visibility:hidden; font-size: 2px;  position:absolute;" />
                <input type="submit" class = "btn btn-danger" value="Sair" style="position:absolute; 
                    right:1%;
                    font-size: 15px;
                    font-family: 'Open Sans'">
                </input>
            </form>
        </div>

        <body style="background-color: white">

            <section class="hero is-success is-fullheight" style="background-color: #d3d3d3" >
                <div class="hero-body">
                    <div class="container has-text-centered">
                        <form action="../controller/action.php" method="post">
                            <div class="column is-4 is-offset-4">
                                <input class="button is-link" name = "id" value ="<?php echo $id;?>" style="visibility:hidden;" />
                                <input class="button is-link" name = "user" value ="<?php echo $user;?>" style="visibility:hidden;" />
                                <div class="box" style="background-color: white">
                                    <input type="submit" class="button is-link" name = "action" value ="Pedidos" />
                                    <input type="submit" class="button is-link" name = "action" value = "Clientes"/>
                                </div>                    
                                <div class="box" style="background-color:white"><div>
                                        <input type="submit" class="button is-link " name="action" Value="Produtos"/>
                                    </div>
                                </div>
                            </div>
                        </form>

                       
                    </div>
                </div>
            </section>
        </body>

        </html>
    <?php
    }else{
        return header('Location: index.php?login=erro');
    }

    ?>