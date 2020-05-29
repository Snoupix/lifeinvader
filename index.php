<!DOCTYPE html>

<?php 
  session_start();
  require 'database.php';
  
  try{
  
    if(isset($_SESSION['username'])){
      $username = $_SESSION['username'];
    }

    $usersReq = $conn->query("SELECT username FROM user");
    $usersReq = $usersReq->fetchAll(PDO::FETCH_ASSOC);
    $srcReqOK = true;
    $isIndex = false;
    if(!empty($_GET['username'])){
      $isIndex = true;
      for($i = 0; $i<=count($usersReq)-1; $i++){
        if($usersReq[$i]['username'] == $_GET['username']){
          $username = $_GET['username'];
          $srcReqOK = true;
          break;
        }else{
          $srcReqOK = false;
        }
      }
    }


    // SQL Querys

    $stalkers = 'SELECT COUNT(*) as stalkers FROM stalking WHERE usernameFK = "'.$username.'";';
    $whoIsHeStalking = 'SELECT stalker FROM stalking WHERE usernameFK = "'.$_SESSION['username'].'";'; // Renvoie les personnes que username stalk


    $stalkers = $conn->query($stalkers);
    $stalkers = $stalkers->fetch(PDO::FETCH_ASSOC);

    $whoIsHeStalking = $conn->query($whoIsHeStalking);
    $whoIsHeStalking = $whoIsHeStalking->fetchAll(PDO::FETCH_ASSOC);

    
    $stalking = [];
    for($i = 0;$i<=count($whoIsHeStalking)-1;$i++){
      $stalking[$i] = $whoIsHeStalking[$i]['stalker'];
    }


    //if($srcReqOK){
      echo 'table: ';
      for($i = 0;$i<=count($whoIsHeStalking)-1;$i++){
        if($stalking[$i] == $_GET['username']){
          $whoIsHeStalking = true;
        }
        echo $stalking[$i].'--';
      }
      echo '<br/>search: '.$_GET['username'];
    //}


  }catch(PDOException $e){
    echo 'Échec lors de la requête SQL : ' . $e->getMessage();
  }

?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Lifeinvader</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link rel="shortcut icon" href="./assets/img/favicon.ico">
</head>
<body>
  <?php require('header.php'); ?>
  <?php if(!empty($_SESSION['username'])): ?>
  <!-- SI L'UTILISATEUR EST CONNECTÉ -->
    <div class="container">
      <div class="row">
        <div class="col">
          <?php
            $req = 'SELECT avatar FROM user WHERE username ="'.$username.'";';
            $avatar = $conn->prepare($req);
            $avatar->execute();
            $icon = $avatar->fetch(PDO::FETCH_ASSOC); // = Array ( [avatar] => path )
          ?>
          <header>
            <div class="container">
              <div class="row">
                <div class="borderPic col-3">
                  <div class="profilePic">
                    <?php echo '<img src="'.$icon['avatar'].'" alt="profile pic" height="95%"/>'; ?>
                  </div>
                </div>
                <div class="col-8" style="padding-right: 0px!important;">
                <!-- <div class="col-auto"> -->
                  <div class="row">
                    <div class="col name">
                      <h1><?php echo $username; ?></h1>
                    </div>
                    <div class="col">
                    <?php if($isIndex != false && $srcReqOK != false): ?>
                        <?php if($whoIsHeStalking): ?>
                        <button class="stalk float-right"><i class="fas fa-plus" style="font-size:12px;font-weight:bold;"></i> Stalk</button>
                        <?php endif; ?>
                        <?php if(!$whoIsHeStalking): ?>
                        <p style="float:right;margin-top:18px;margin-bottom:0px;"><i class="fa fa-check" style="font-weight:bold;"></i> Stalking</p>
                        <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="row banner">
                    <div class="col description">
                      <div class="row">
                        <div class="col-6">
                          <p>Type of account</p>
                          <p>Description</p>
                        </div>
                        <div class="col-6">
                          <span class="float-right stalkers"><?php echo $stalkers['stalkers']; ?> Stalkers</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <?php if(!$srcReqOK): ?>
            <!-- TOAST ERROR -->
            <div aria-live="polite" aria-atomic="true" class="toastError d-flex justify-content-center align-items-center" style="min-height: 200px;">
              <div style="opacity:1;" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
                <div class="toast-header">
                  <strong class="mr-auto">Error</strong>
                </div>
                <div class="toast-body"> 
                  Woops, this username doesn't exists, sorry! 
                </div>
              </div>
            </div>
          <?php endif; ?>



        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php if(empty($_SESSION['username'])): ?>
    <!-- SI L'UTILISATEUR N'EST PAS CONNECTÉ -->
      <div class="container">
        <div class="row">
          <div class="col">
            <p style='text-align:center; margin: auto;'>Accueil non-connecté</p>
          </div>
        </div>
      </div>
    <?php endif; ?>

    
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
<script src="main.js"></script>
</html>