<?php
#Incluir messages
 include 'messages.php';
 include '../core/localapi.php';
 if($_POST){
  echo localAPI::post($_POST);
 }
?>
<!DOCTYPE html>
<html lang="es-MX">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mensajes - WVT</title>
<meta name="description" content="WVT: Mensajes" />
<meta name="keywords" content="wvt, tracking" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="image_src" href="" />

    <!-- Bootstrap core CSS -->
   <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
   <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
   <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

   <!-- Custom styles for this template -->
   <link href="style.css" rel="stylesheet">
   <link href="../theme/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body>    
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>WVT: Mensajes</h1>
      </div>
    </div>
    <div class="row content">
      <div class="col-xs-12"><h2>Formularios de contacto AJAX</h2></div>
      <div class="col-sm-6">
        <h3 class="text-center">Default: Notificacion</h3>
        <?php
        Messages::Form();
        ?>
      </div>
      <div class="col-sm-6">
        <h3 class="text-center">Nombre y Correo necesarios</h3>
         <?php
        Messages::Form(array(
              'name'  => true,
              'email' => true
              ));
        ?>
      </div>
    </div>
        <div class="row content">
      <div class="col-xs-12"><h2>Formularios de contacto</h2></div>
      <div class="col-sm-6">
        <h3 class="text-center">Default: Notificacion</h3>
        <?php
        Messages::Form(array(
              'class' => ''
              ));
        ?>
      </div>
      <div class="col-sm-6">
        <h3 class="text-center">Nombre y Correo necesarios</h3>
         <?php
        Messages::Form(array(
              'class' => '',
              'name'  => true,
              'email' => true
              ));
        ?>
      </div>
    </div>
  </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type='text/javascript' src="../core/code.js"></script>
    <script type='text/javascript' src="messages.js"></script>
     <script type="text/javascript">
  $(document).ready(function () {
    $('.wvt-messages').wvt_messages();
  });
  </script>
  </body>
</html>
