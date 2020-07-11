<!DOCTYPE html>

<?php

  require 'database.php';

  try{
  session_start();

  if(!empty($_POST['username']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT username, password FROM user WHERE username=:username');
    $records->bindParam(':username', $_POST['username']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['username'] = $_POST['username'];
      $messageC = "Connected!";
      header("Refresh:2; url=dashboard.php");
    } else {
      $message = 'Incorrect Password';
    }
  }

?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Lifeinvader</title>
  <link rel="stylesheet" href="./assets/css/header.css">
  <link rel="stylesheet" href="./assets/css/signup.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="shortcut icon" href="./assets/img/favicon.ico">
</head>
<body>
  <?php require('header.php') ?>

  <section class="container mrgIndex text-center">
    <h1>Connexion</h1>
    <span>ou <a href="signup.php">Inscription</a></span>

    <?php if(!empty($message)): ?>
      <p class="alert alert-danger"><?= $message ?></p>
    <?php endif ?>
    <?php if(!empty($messageC)): ?>
      <p class="alert alert-info"><?= $messageC ?></p>
    <?php endif ?>
    <form action="signin.php" method="post">
      <input type="text" name="username" placeholder="Nom d'utilisateur">
      <input type="password" name="password" placeholder="Mot de passe">
      <input type="submit" value="Send">
    </form>
  </section>


  <?php

  }catch(PDOException $e){
    echo 'Échec lors de la requête SQL : ' . $e->getMessage();
  }

  ?>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="main.js"></script>
</html>