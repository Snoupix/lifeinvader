<!DOCTYPE html>

<?php

  session_start();
  require 'database.php';

  try{

    function incoming_files() {
      $files = $_FILES;
      $files2 = [];
      foreach ($files as $input => $infoArr) {
          $filesByInput = [];
          foreach ($infoArr as $key => $valueArr) {
              if (is_array($valueArr)) { // file input "multiple"
                  foreach($valueArr as $i=>$value) {
                      $filesByInput[$i][$key] = $value;
                  }
              }
              else { // -> string, normal file input
                  $filesByInput[] = $infoArr;
                  break;
              }
          }
          $files2 = array_merge($files2,$filesByInput);
      }
      $files3 = [];
      foreach($files2 as $file) { // let's filter empty & errors
          if (!$file['error']) $files3[] = $file;
      }
      return $files3;
    }
  
    $tmpFiles = incoming_files();
    //print_r($tmpFiles[0]);
    
    if(isset($tmpFiles[0])){
      if($tmpFiles[0]["type"] == "image/png"){
        $imgType = ".png";
      }elseif($tmpFiles[0]["type"] == "image/jpg"){
        $imgType = ".jpg";
      }else{
        $imgType = ".jpeg";
      }
    }

    $targetDir = "./assets/usersAvatar/";

    if(isset($_POST['username'])){
      if(move_uploaded_file($tmpFiles[0]["tmp_name"], $targetDir.$_POST["username"].$imgType)) {
        $avatar = "./assets/usersAvatar/".$_POST['username'].$imgType;
        //echo "The file ". $tmpFiles[0]["name"] . " has been uploaded.";
      }else{
        $avatar = "./assets/usersAvatar/default.png";
      }
    }


    $usersReq = $conn->query("SELECT username FROM user");
    $usersReq = $usersReq->fetchAll(PDO::FETCH_ASSOC);
    $users = []; // Table of all usernames taken
    for($i = 0; $i<=count($usersReq)-1; $i++){
      $users[$i] = $usersReq[$i]['username'];
    }

    $stop = false; // Breakpoint

    if (isset($_POST['username']) && !empty($_POST['password'])){
      $sql = 'INSERT INTO user (username, password, avatar) VALUES (:username, :password, :avatar)';
      $req = $conn->prepare($sql);
      $req->bindParam(':avatar', $avatar);
      
      for($i = 0; $i<count($users); $i++){
        if($_POST['username'] == $users[$i]){
          $stop = true;
        }
      }
      
      //$req = $conn->prepare($sql);
      $req->bindParam(':username', $_POST['username']);
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $req->bindParam(':password', $password);

      if($stop == false){
        if($_POST["password"] != $_POST["confirm_password"]){
          $messageErr = "The passwords do not match";
        }else{
          if($req->execute()) {
            $message = 'Successfully created user';
            $_SESSION["username"] = $_POST["username"];
          }else{
            $message = 'Sorry there must have been an issue creating new user. (SQL Error)';
          }
        }
      }else{
        $messageErr = 'Sorry, this username is already taken';
      }
    }else{
      $messageErr = 'Please retype your password and make sure they are the same.';
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
    <?php if(isset($_POST["username"]) && !empty($message)): ?>
      <p class="alert alert-info"><?= $message ?></p>
    <?php endif; ?>
    <?php if(isset($_POST['username']) && !empty($messageErr)): ?>
      <p class="alert alert-danger"><?= $messageErr ?></p>
    <?php endif; ?>
    <h1>SignUp</h1>
    <span>or <a href="signin.php">SignIn</a></span>
    <form action="signup.php" method="post" enctype="multipart/form-data" style="margin-top: 12px;">
      <label for="avatar" style="vertical-align: top;">Avatar: (non obligatoire)<br/>Taille recommandée 172 x 172px<br/>Taille ne dépassant pas 1.30 Mo</label><br/>
      <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg, image/jpg">
      <input type="text" name="username" placeholder="Nom d'utilisateur">
      <input type="password" name="password" placeholder="Mot de passe (6 carac. min)">
      <input type="password" name="confirm_password" placeholder="Confirmation du mot de passe">
      <input type="submit" value="Send">
    </form>
  </section>


  <?php

  }catch(PDOException $e){
    echo 'Échec lors de la requête SQL : ' . $e->getMessage() . '<br/>';
    echo 'Retour à la page d\'accueil : <a href="index.php">Lifeinvader</a>';
  }

  ?>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="main.js"></script>
</html>