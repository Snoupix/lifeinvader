<?php
  session_start();
  require 'database.php';
  date_default_timezone_set('Europe/Paris');
  
  try{

    // SQL QUERYS


    


  }catch(PDOException $e){
    echo 'Échec lors de la requête SQL : ' . $e->getMessage();
  }
?>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta property="og:url"           content="https://www.domain.com/index.php" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Lifeinvader Atlantiss" />
  <meta property="og:description"   content="Le réseau social du serveur GTA RP Atlantiss. Discord : https://discord.gg/w5HBjWw" />
  <meta property="og:image"         content="./assets/img/favicon.ico" />

  <title>Lifeinvader</title>

  <link rel="stylesheet" href="./assets/css/header.css">
  <link rel="stylesheet" href="./assets/css/dashboard.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link rel="shortcut icon" href="./assets/img/favicon.ico">
</head>
<body>
  <?php require('header.php'); ?>
  <?php if(empty($_SESSION['username'])): ?> <!-- If disconnected, display every account -->

  <div class="container">
    <div class="row">
      <div class="col-9" style="height:1500px;">

      </div>
      <div class="col-3 ads">
        <h3>Sponsored</h3>
        <?php
          #Loop ads
        ?>
        <div class="ad">
          <h5><a href="index.php?username=Premium+Deluxe+Motorsport">Premium Deluxe Motorsport</a></h5>
        </div>
      </div>
    </div>
  </div>

  <?php else: ?> <!-- If connected, display every account stalked -->



  <?php endif; ?>



</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
<script src="main.js"></script>
</html>