<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if ($_SESSION["tipo"]!=='admin'){
  session_destroy();
  header("Location:error.php");
}
  //Bucle que si $_GET no tiene nada, diga que hay que pasar algo
  if (empty($_GET))
  die("Tienes que pasar algun parametro por GET.");
  //Declaración de la variable item y se le introduce lo que viene de GET
  $a = $_GET['id'];
?>
<?php
  include("selectema.php");
 ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Noticias Gorgé</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../vendor/bootstrap/css/<?php echo $style ?>.css" type="text/css" media="screen" />

    <!-- Theme CSS -->
    <link href="../css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
  <?php
  include_once("header.php");
   ?>


    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('../img/gatito.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>Editar noticia</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <?php if (!isset($_POST["ntitular"])) : ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p>Editar noticia</p>

                <form  name="regis" id="registrer" novalidate method="post" enctype="multipart/form-data">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Nuevo titular</label>
                            <?php
                            $connection = new mysqli("localhost", "root", "2asirtriana", "proyecto_blog2");

                            if ($connection->connect_errno) {
                                printf("Connection failed: %s\n", $connection->connect_error);
                                exit();
                            }
                                        if ($result = $connection->query("SELECT titular
                                    FROM noticia where idnoticia='$a';")) {
                                    while($obj = $result->fetch_object()) {
                                    echo'<input type="text" name="ntitular" class="form-control" value="'.$obj->titular.'" id="titular" required>';
                                    }
                                    $result->close();
                                    unset($obj);
                                    unset($connection);
                                  }
                                  ?>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Nuevo cuerpo</label>
                            <?php
                            $connection = new mysqli("localhost", "root", "2asirtriana", "proyecto_blog2");

                            if ($connection->connect_errno) {
                                printf("Connection failed: %s\n", $connection->connect_error);
                                exit();
                            }
                                        if ($result = $connection->query("SELECT noticia.cuerpo,categorias.valor
                                    FROM noticia join categorias on noticia.idCategoria=categorias.idCategoria where idnoticia='$a';")) {
                                    while($obj = $result->fetch_object()){
                                    $cat=$obj->valor;
                                    echo'<textarea rows="5" class="form-control" name="ncuerpo" id="cuerpo" required>'.$obj->cuerpo.'</textarea>';
                                    }
                                    $result->close();
                                    unset($obj);
                                    unset($connection);
                                  }
                                  ?>
                                <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                          <label>Categoría</label>
                            <?php
                            $connection = new mysqli("localhost", "root", "2asirtriana", "proyecto_blog2");

                            if ($connection->connect_errno) {
                                printf("Connection failed: %s\n", $connection->connect_error);
                                exit();
                            }
                                       if ($result2 = $connection->query("SELECT *  FROM categorias order by idCategoria;")) {
                                            echo'<select class="form-control" name="ncategoria" placeholder="Categoría" id="cat">';
                                              var_dump($result2);
                                               while($obj2 = $result2->fetch_object()) {
                                                 if (($obj2->valor)==$cat) {
                                                   echo "<option value='$obj2->idCategoria' selected>$obj2->valor</option>";
                                                 }else{
                                                   echo "<option value='$obj2->idCategoria'>$obj2->valor</option>";
                                                 }
                                               }
                                               $result2->close();
                                               unset($obj2);
                                               unset($connection);
                                            echo'</select>';
                                             }
                            ?>

                          </select>
                                <p class="help-block text-danger"></p>
                        </div>
                    </div>

                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-default">Editar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
  <?php else: ?>
    <?php
       $connection = new mysqli("localhost", "root", "2asirtriana", "proyecto_blog2");
        if ($connection->connect_errno) {
          printf("Connection failed: %s\n", $connection->connect_error);
          exit();
          }
          $titular = $_POST['ntitular'];
          $cuerpo = nl2br($_POST['ncuerpo']);
        $categoria = $_POST['ncategoria'];

            if(isset($_POST['ntitular']) && $_POST['ntitular']!=="" ){
          $consulta= "UPDATE `noticia` SET `titular` = '$titular',`fModificacion` = sysdate()
           WHERE `noticia`.`idnoticia` = '$a' ";
          $result = $connection->query($consulta);
           }
          if(isset($_POST['ncuerpo']) && $_POST['ncuerpo']!=="" ){
            $consulta= "UPDATE `noticia` SET `cuerpo` = '$cuerpo',`fModificacion` = sysdate()
             WHERE `noticia`.`idnoticia` = '$a' ";
            $result = $connection->query($consulta);
          }
   if(isset($_POST['ncategoria']) && $_POST['ncategoria']!=="" ){
            $consulta= "UPDATE `noticia` SET `idcategoria` = '$categoria',`fModificacion` = sysdate()
             WHERE `noticia`.`idnoticia` = '$a' ";
            $result = $connection->query($consulta);
          }

            if (!$result) {
              echo "error";
            }else{
               echo "Datos cambiados";
               header("Refresh:1; url=paneladmin.php");
            }

     ?>
   <?php endif ?>
    <hr>

    <?php
    include("footer.php");
     ?>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>


    <!-- Theme JavaScript -->
    <script src="../js/clean-blog.min.js"></script>

</body>

</html>
