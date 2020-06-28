<!DOCTYPE html>

<?php 
  session_start();
  require 'database.php';
  date_default_timezone_set('Europe/Paris');

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
  
  try{

    $srcReqOK = true;
    $isIndex = false;
    $isStalking = false;
  

    if(isset($_SESSION['username'])){
      $username = $_SESSION['username'];
    }

    $usersReq = $conn->query("SELECT username FROM user");
    $usersReq = $usersReq->fetchAll(PDO::FETCH_ASSOC);

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


    $avatarReq = 'SELECT avatar FROM user WHERE username ="'.$username.'";';
    $stalkers = 'SELECT COUNT(*) as stalkers FROM stalking WHERE stalked = "'.$username.'";';
    $whoIsHeStalking = (isset($_SESSION['username'])) ? 'SELECT stalked FROM stalking WHERE usernameFK = "'.$_SESSION['username'].'";' : ''; // Renvoie les personnes que username stalk
    $stalkReq = 'INSERT INTO stalking VALUES (:username, :userSrc)';
    $unstalkReq = (isset($_SESSION['username'])) ? 'DELETE FROM stalking WHERE usernameFK = "'.$_SESSION['username'].'" AND stalked = :getUsername;' : '';
    $typeReq = 'SELECT type FROM user WHERE username = "'.$username.'";';
    $descReq = 'SELECT description FROM user WHERE username = "'.$username.'";';
    $setType = (isset($_SESSION['username'])) ? 'UPDATE user SET type = :type WHERE username = "'.$_SESSION['username'].'";' : '';
    $setDesc = (isset($_SESSION['username'])) ? 'UPDATE user SET description = :desc WHERE username = "'.$_SESSION['username'].'";' : '';
    $setAbout = (isset($_SESSION['username'])) ? 'UPDATE user SET about = :about WHERE username = "'.$_SESSION['username'].'";' : '';
    $postReq = 'SELECT * FROM post WHERE usernameFK = "'.$username.'";';
    $newPost = 'INSERT INTO post (usernameFK, message, image, date) VALUES (:username, :txt, :image, :date)';
    $aboutReq = 'SELECT about FROM user WHERE username = "'.$username.'";';
    $imagesReq = 'SELECT image, message FROM post WHERE usernameFK = "'.$username.'" AND image != "NULL";';
    $adReq = 'SELECT * FROM ads';
    $updateAvatar = (isset($_SESSION['username'])) ? 'UPDATE user SET avatar = :avatar WHERE username ="'.$_SESSION['username'].'";' : '';
    $likesReq = 'SELECT * FROM likes';
    $plusLike = 'INSERT INTO likes VALUES (:id, :wholiked);';
    $unLike = 'DELETE FROM likes WHERE id = :id AND userWhoLike = :user ;';
    $commentsReq = 'SELECT * FROM comments';
    $allUsers = 'SELECT * FROM user';
    

    if(isset($_SESSION['username'])){

      $avatar = $conn->prepare($avatarReq);
      $avatar->execute();
      $icon = $avatar->fetch(PDO::FETCH_ASSOC); // = Array ( [avatar] => path )

      $stalkers = $conn->query($stalkers);
      $stalkers = $stalkers->fetch(PDO::FETCH_ASSOC);

      $whoIsHeStalking = $conn->query($whoIsHeStalking);
      $whoIsHeStalking = $whoIsHeStalking->fetchAll(PDO::FETCH_ASSOC);

      $typeAcc = $conn->query($typeReq);
      $type = $typeAcc->fetch(PDO::FETCH_ASSOC);

      $descAcc = $conn->query($descReq);
      $description = $descAcc->fetch(PDO::FETCH_ASSOC);

      $postReq = $conn->query($postReq);
      $postRes = $postReq->fetchAll(PDO::FETCH_ASSOC);

      $aboutReq = $conn->query($aboutReq);
      $aboutRes = $aboutReq->fetch(PDO::FETCH_ASSOC);

      $imagesFetched = $conn->query($imagesReq);
      $imagesFetched = $imagesFetched->fetchAll(PDO::FETCH_ASSOC);

      $adReq = $conn->query($adReq);
      $ads = $adReq->fetchAll(PDO::FETCH_ASSOC);

      $likesReq = $conn->query($likesReq);
      $allLikes = $likesReq->fetchAll(PDO::FETCH_ASSOC);

      $commentsReq = $conn->query($commentsReq);
      $comments = $commentsReq->fetchAll(PDO::FETCH_ASSOC);
      
      $allUsers = $conn->query($allUsers);
      $allUsers = $allUsers->fetchAll(PDO::FETCH_ASSOC);

    
    }

  

    // click on stalk/unstalk button
    $stalk = $conn->prepare($stalkReq);
    $stalk->bindParam(':userSrc', $_GET['username']);
    $stalk->bindParam(':username', $_SESSION['username']);
    if(isset($_POST['stalk']) && $_GET['username'] != $_SESSION['username']){ // stalk
      $stalk->execute();
      header("Refresh:0");
    }
    
    if(isset($_SESSION['username'])){
      for($i = 0;$i<=count($whoIsHeStalking)-1;$i++){
        if($whoIsHeStalking[$i]['stalked'] == $_GET['username']){
          $isStalking = true;
        }
      }
    }

    $unstalk = $conn->prepare($unstalkReq);
    $unstalk->bindParam(':getUsername', $_GET['username']);
    if(isset($_POST['unstalk']) && $isStalking){ // unstalk
      $unstalk->execute();
      header("Refresh:0");
    }
    

    // add description and/or type of account
    if(isset($_POST['editDone'])){
      if(!empty($_POST['typeEdit'])){
        $setType = $conn->prepare($setType);
        $setType->bindParam(':type', $_POST['typeEdit']);
        $setType->execute();
      }

      if(!empty($_POST['descEdit'])){
        $setDesc = $conn->prepare($setDesc);
        $setDesc->bindParam(':desc', $_POST['descEdit']);
        $setDesc->execute();
      }

      if(!empty($_POST['aboutEdit'])){
        echo $_POST['aboutEdit'];
        $setAbout = $conn->prepare($setAbout);
        $setAbout->bindParam(':about', $_POST['aboutEdit']);
        $setAbout->execute();
      }
      header("Refresh:0");
    }
    if(isset($_POST['unset'])){
      unset($_POST['editDone']);
    }



    $tmpFiles = incoming_files();
    if(isset($tmpFiles[0])){
      if($tmpFiles[0]["type"] == "image/png"){
        $imgType = ".png";
      }elseif($tmpFiles[0]["type"] == "image/jpg"){
        $imgType = ".jpg";
      }else{
        $imgType = ".jpeg";
      }
    }
    $null = 'NULL';
    $targetDir = "./assets/postImages/".$username."/";
    if(isset($tmpFiles[0])){
      $imgPathName = $targetDir.$tmpFiles[0]["name"];
    }

    if(!empty($_POST['postTxt'])){ // upload a post with some text
      $newPost = $conn->prepare($newPost);
      $newPost->bindParam(':username', $_SESSION['username']);
      $newPost->bindParam(':txt', $_POST['postTxt']);
      if(isset($tmpFiles[0])){ // if the post has an image
        if(!is_dir($targetDir)){
          mkdir($targetDir, 0700);
        }
        if(!move_uploaded_file($tmpFiles[0]["tmp_name"], $targetDir.$tmpFiles[0]["name"])) {
          die("Cannot move the uploaded file");
        }
        $newPost->bindParam(':image', $imgPathName);
      }else{ // if the post hasn't an image (only text)
        $newPost->bindParam(':image', $null);
      }
      $newPost->bindParam(':date', $_POST['date']);
    }elseif(isset($tmpFiles[0]) && isset($_POST['postSub'])){ // Upload image post without text
      if(!is_dir($targetDir)){
        mkdir($targetDir, 0700);
      }
      if(!move_uploaded_file($tmpFiles[0]["tmp_name"], $targetDir.$tmpFiles[0]["name"])){
        die("Cannot move the uploaded file");
      }
      $newPost = $conn->prepare($newPost);
      $newPost->bindParam(':username', $_SESSION['username']);
      $newPost->bindParam(':txt', $null);
      $newPost->bindParam(':image', $imgPathName);
      $newPost->bindParam(':date', $_POST['date']);
    }
    if(isset($_POST['postSub']) && !empty($_POST['postTxt'])){
      $newPost->execute();
      header("Refresh:0");
    }

    if(isset($_POST['changeProfilePic']) && $tmpFiles[0]){
      $targetFile = "./assets/usersAvatar/".$username.$imgType;
      $updateAvatar = $conn->prepare($updateAvatar);
      $updateAvatar->bindParam(':avatar', $targetFile);
      if(!move_uploaded_file($tmpFiles[0]["tmp_name"], $targetFile)){
        die("Cannot move the uploaded file");
      }
      $updateAvatar->execute();
      header("Cache-Control: no-cache, must-revalidate");
      header("Refresh:2, Expires: 0");
    }

    
    if(isset($_POST['likePost'])){
      $breakpoint = false;
      foreach($allLikes as $like){
        if($like['userWhoLike'] == $_SESSION['username'] && $_POST['idLiked'] == $like['id']){
          $breakpoint = true;
        }
      }
      if(!$breakpoint){
        $plusLike = $conn->prepare($plusLike);
        $plusLike->bindParam(':id', $_POST['idLiked']);
        $plusLike->bindParam(':wholiked', $_SESSION['username']);
        $plusLike->execute();
        header("Refresh:0");
      }
    }

    if(isset($_POST['unLike'])){
      $unLike = $conn->prepare($unLike);
      $unLike->bindParam(':user', $_SESSION['username']);
      $unLike->bindParam(':id', $_POST['idLiked']);
      $unLike->execute();
      header("Refresh:0");
    }

    
    

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
  <link rel="stylesheet" href="./assets/css/index.css">
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
      <?php if(!$srcReqOK): ?>
          <!-- TOAST ERROR -->
          <div class="col-12">
            <div aria-live="polite" aria-atomic="true" class="toastError d-flex justify-content-center align-items-center" style="min-height: 200px;">
              <div style="opacity:1;" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
                <div class="toast-header">
                  <strong class="mr-auto">Error</strong>
                </div>
                <div class="toast-body"> 
                  Woops, ce nom d'utilisateur n'existe pas! 
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <div class="col">
        <header>
          <div class="container">
            <div class="row">
              <div class="borderPic col-3">
                <?php if(!isset($_POST['edit'])): ?>
                <div class="profilePic">
                  <?php echo '<img src="'.$icon['avatar'].'" alt="profile pic" draggable="false" height="95%"/>'; ?>
                </div>
                <?php else: ?>
                <div class="profilePicEdit">
                  <form action="index.php" method="post" enctype="multipart/form-data">
                    <label for="profilePic">Nouvelle photo</label>
                    <input type="file" name="profilePic" id="profilePic" accept="image/png, image/jpeg, image/jpg">
                    <input type="submit" name="changeProfilePic" value="Changer" class="btn-sm btn-dark">
                  </form>
                </div>
                <?php endif; ?>
              </div>
              <div class="col-8" style="padding-right: 0px!important;">
                <div class="row">
                  <div class="col name">
                    <h1><?php echo $username; ?></h1>
                  </div>
                  <div class="col">
                  <?php if($isIndex != false && $srcReqOK != false): ?>
                      <?php if(!$isStalking): ?>
                        <form id="stalkForm" method="POST">
                          <button type="submit" class="stalk float-right" name="stalk"><i class="fas fa-plus" style="font-size:12px;font-weight:bold;"></i> Stalk</button>
                        </form>
                      <?php else: ?>
                        <form id="stalkForm" method="POST">
                          <button id="unstalkButton" type="submit" class="stalk float-right" name="unstalk">
                            <p class="pstalk" style="float:right;margin-top:0px;margin-bottom:0px!important;"><i class="fa fa-check" style="font-weight:bold;"></i> Stalking</p>
                          </button>
                        </form>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php 
                      if(empty($_GET['username'])){
                        echo '<form method="POST" action="index.php">';
                        echo '<button name="edit" type="submit" class="btn-sm btn-dark float-right" style="margin-top:7%;">EDIT</button>';
                        echo '</form>';
                      }
                    ?>
                  </div>
                </div>
                <div class="row banner">
                  <div class="col description">
                    <div class="row">
                      <div class="col-8">
                        <?php if(isset($_POST['edit'])): ?>
                          <form method="POST" id="descForm">
                            <input name="typeEdit" type="text" placeholder="Type of account" />
                            <input name="descEdit" type="text" placeholder="Description" />
                            <input class="btn-sm btn-dark" name="editDone" type="submit" />
                            <input class="btn-sm btn-dark" name="unset" value="Cancel" type="submit" />
                          </form>
                        <?php else: ?>
                            <?php if($type['type'] == NULL): ?>
                              <p>Type de compte</p>
                            <?php else: ?>
                              <p><?php echo $type['type']; ?></p>
                            <?php endif; ?>
                            <?php if($description['description'] == NULL): ?>
                              <p>Description</p>
                            <?php else: ?>
                              <p><?php echo $description['description']; ?></p>
                          <?php endif; ?>
                        <?php endif; ?>
                      </div>
                      <div class="col-4">
                        <span class="float-right stalkers"><?php echo $stalkers['stalkers']; ?> Stalkers</span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if(empty($_GET['username'])): ?>
                <div class="row">
                  <div class="col">
                    <div id="postOpen" style="display:none;">
                      <button id="postClose" style="border:none;background:none;float:right;outline:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                      <form id="postpost" method="POST" action="index.php" enctype="multipart/form-data">
                        <input type="hidden" name="date">
                        <textarea name="postTxt" id="postTxt" cols="40" placeholder="Postez un message de 420 caractères max."></textarea>
                        <label for="postImageButton">Choisir une image</label>
                        <input type="file" id="postImageButton" name="postImage" accept="image/png, image/jpeg, image/jpg">
                        <input class="raise" name="postSub" type="submit" value="Envoyer">
                      </form>
                    </div>
                    <div id="postSmth">
                      <button class="raise" id='postBtn'>Poster quelque chose..</button>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </header>


        </div>
      </div>
      <div class="row">
        <div class="col-3 about">
          <div class="row">
            <div class="col-12">
              <p style="font-weight:bold;color:#666;line-height:1.15;">About</p>
              <?php if(isset($_POST['edit'])): ?>
                <form method="POST" id="aboutForm">
                  <textarea name="aboutEdit" cols="18" rows="10" placeholder="write things about you"></textarea>
                  <input name="editDone" type="submit" value="OK" class="btn-sm btn-dark">
                </form>
              <?php else: ?>
                <?php if($aboutRes['about'] == NULL): ?>
                  <p></p>
                <?php else: ?>
                  <p><?php echo $aboutRes['about']; ?></p>
                <?php endif; ?>
              <?php endif; ?>
            </div>
            <div class="col-12 divImage">
              <?php if(!empty($imagesFetched)): ?>
              <div class="toggleImageDiv">
                <p style="font-weight:bold;color:#666;line-height:1.15;">Images</p>
              </div>
              <?php else: ?>
                <p style="font-weight:bold;color:#666;line-height:1.15;">Aucune image postée</p>
              <?php endif; ?>
            </div>
          </div>
          
        </div>
        <div class="col-6 wall" id="wall">
          <?php
            # Boucle qui charge tout les posts
            $reversedArray = array_reverse($postRes, true);

            foreach($reversedArray as $key){
              $i = 0;
              $yetLiked = false;
              $comment = [];
              $i2 = 0;
              $commAuth = [];
              foreach($comments as $comm){
                if($key['id'] == $comm['idPost']){
                  $comment[$i2] = $comm;
                  foreach($allUsers as $user){
                    if($user['username'] == $comm['author']){
                      $commAuth[$i2] = $user;
                    }
                  }
                  $i2 = $i2+1;
                }
              }
              if($key['image'] != 'NULL' && $key['message'] != "NULL"){ // Post text avec image
                foreach($allLikes as $like){
                  if($like['id'] == $key['id']){
                    $i = $i+1;
                  }
                  if($like['userWhoLike'] == $_SESSION['username'] && $key['id'] == $like['id']){
                    $yetLiked = true;
                  }
                  $likeCount = $i;
                }
                echo '<div class="post">';
                  echo '<div class="postBanner">';
                    echo '<img src="'.$icon['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                    echo '<a href="#">'.$username.'</a>';
                    echo '<span>Posté '.$key['date'].'</span>';
                    echo '<hr/>';
                  echo '</div>';
                  echo '<div class="postImage">';
                    echo '<img src="'.$key['image'].'" alt="'.$key['message'].'" width="50%"/>';
                    echo '<hr/>';
                  echo '</div>';
                  echo '<div class="postContent">';
                    echo '<p>'.$key['message'].'</p>';
                  echo '</div>';
                  echo '<div class="postFooter">';
                    echo '<hr style="margin-top: 0.5rem;margin-bottom: 0.5rem;" />';
                    if($yetLiked){
                      echo '<form method="POST">';
                        echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                        echo '<button class="liked" name="unLike" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                        echo (!empty($comment)) ? '<span class="displayComms" style="padding-top:1%;cursor:pointer;float:right;"><i class="fas fa-chevron-down"></i> Commentaires <i class="fas fa-chevron-down"></i></i></span>' : "";
                      echo '</form>';
                    }else{
                      echo '<form class="formLike" method="POST">';
                        echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                        echo '<button name="likePost" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                        echo (!empty($comment)) ? '<span class="displayComms" style="padding-top:1%;cursor:pointer;float:right;"><i class="fas fa-chevron-down"></i> Commentaires <i class="fas fa-chevron-down"></i></i></span>' : "";
                      echo '</form>';
                    }
                    if(!empty($comment)){
                      echo '<div class="comms id'.$key['id'].'" style="display:none;">';
                      echo '<hr style="margin-top: 0.7rem;margin-bottom: 0.5rem;" />';
                      for($i = 0;$i<count($comment);$i++){
                          echo '<div class="comment">';
                            echo '<div class="comm-banner">';
                              echo '<img src="'.$commAuth[$i]["avatar"].'" alt="'.$commAuth[$i]["username"].' profilePic">';
                              echo '<a href="index.php?username='.$comment[$i]['author'].'">'.$comment[$i]['author'].'</a>';
                              echo '<span>'.$comment[$i]['date'].'</span>';
                            echo '</div>';
                            echo '<div class="comm-content">';
                              echo '<p>'.$comment[$i]['message'].'</p>';
                            echo '</div>';
                          echo '</div>';
                          echo '<hr/>';
                      }
                      echo '</div>';
                    }
                  echo '</div>';
                echo '</div>';
              }
              if($key['image'] == "NULL" && $key['message'] != "NULL"){ // Post text sans image
                foreach($allLikes as $like){
                  if($like['id'] == $key['id']){
                    $i = $i+1;
                  }
                  if($like['userWhoLike'] == $_SESSION['username'] && $key['id'] == $like['id']){
                    $yetLiked = true;
                  }
                  $likeCount = $i;
                }
                echo '<div class="post">';
                  echo '<div class="postBanner">';
                    echo '<img src="'.$icon['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                    echo '<a href="#">'.$username.'</a>';
                    echo '<span>Posté '.$key['date'].'</span>';
                    echo '<hr/>';
                  echo '</div>';
                  echo '<div class="postContent">';
                    echo '<p>'.$key['message'].'</p>';
                  echo '</div>';
                  echo '<div class="postFooter">';
                    echo '<hr style="margin-top: 0.7rem;margin-bottom: 0.5rem;" />';
                    if($yetLiked){
                      echo '<form method="POST">';
                        echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                        echo '<button class="liked" name="unLike" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                        echo (!empty($comment)) ? '<span class="displayComms" style="padding-top:1%;cursor:pointer;float:right;"><i class="fas fa-chevron-down"></i> Commentaires <i class="fas fa-chevron-down"></i></i></span>' : "";
                      echo '</form>';
                    }else{
                      echo '<form class="formLike" method="POST">';
                        echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                        echo '<button name="likePost" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                        echo (!empty($comment)) ? '<span class="displayComms" style="padding-top:1%;cursor:pointer;float:right;"><i class="fas fa-chevron-down"></i> Commentaires <i class="fas fa-chevron-down"></i></i></span>' : "";
                      echo '</form>';
                    }
                    if(!empty($comment)){
                      echo '<div class="comms id'.$key['id'].'" style="display:none;">';
                      echo '<hr style="margin-top: 0.5rem;margin-bottom: 0.5rem;" />';
                      for($i = 0;$i<count($comment);$i++){
                          echo '<div class="comment">';
                            echo '<div class="comm-banner">';
                            echo '<img src="'.$commAuth[$i]["avatar"].'" alt="'.$commAuth[$i]["username"].' profilePic">';
                              echo '<a href="index.php?username='.$comment[$i]['author'].'">'.$comment[$i]['author'].'</a>';
                              echo '<span>'.$comment[$i]['date'].'</span>';
                            echo '</div>';
                            echo '<div class="comm-content">';
                              echo '<p>'.$comment[$i]['message'].'</p>';
                            echo '</div>';
                          echo '</div>';
                          echo '<hr/>';
                      }
                      echo '</div>';
                    }
                  echo '</div>';
                echo '</div>';
              }
              if($key['message'] == "NULL"){ // Post avec image seule
                foreach($allLikes as $like){
                  if($like['id'] == $key['id']){
                    $i = $i+1;
                  }
                  if($like['userWhoLike'] == $_SESSION['username'] && $key['id'] == $like['id']){
                    $yetLiked = true;
                  }
                  $likeCount = $i;
                }
                echo '<div class="post">';
                  echo '<div class="postBanner">';
                    echo '<img src="'.$icon['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                    echo '<a href="#">'.$username.'</a>';
                    echo '<span>Posté '.$key['date'].'</span>';
                    echo '<hr/>';
                  echo '</div>';
                  echo '<div class="postImage">';
                    echo '<img src="'.$key['image'].'" alt="Post Picture" width="50%"/>';
                  echo '</div>';
                  echo '<div class="postFooter">';
                    echo '<hr/>';
                    if($yetLiked){
                      echo '<form method="POST">';
                        echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                        echo '<button class="liked" name="unLike" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                        echo (!empty($comment)) ? '<span class="displayComms" style="padding-top:1%;cursor:pointer;float:right;"><i class="fas fa-chevron-down"></i> Commentaires <i class="fas fa-chevron-down"></i></i></span>' : "";
                      echo '</form>';
                    }else{
                      echo '<form class="formLike" method="POST">';
                        echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                        echo '<button name="likePost" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                        echo (!empty($comment)) ? '<span class="displayComms" style="padding-top:1%;cursor:pointer;float:right;"><i class="fas fa-chevron-down"></i> Commentaires <i class="fas fa-chevron-down"></i></i></span>' : "";
                      echo '</form>';
                    }
                    if(!empty($comment)){
                      echo '<div class="comms id'.$key['id'].'" style="display:none;">';
                      echo '<hr style="margin-top: 0.7rem;margin-bottom: 0.5rem;" />';
                      for($i = 0;$i<count($comment);$i++){
                          echo '<div class="comment">';
                            echo '<div class="comm-banner">';
                            echo '<img src="'.$commAuth[$i]["avatar"].'" alt="'.$commAuth[$i]["username"].' profilePic">';
                              echo '<a href="index.php?username='.$comment[$i]['author'].'">'.$comment[$i]['author'].'</a>';
                              echo '<span>'.$comment[$i]['date'].'</span>';
                            echo '</div>';
                            echo '<div class="comm-content">';
                              echo '<p>'.$comment[$i]['message'].'</p>';
                            echo '</div>';
                          echo '</div>';
                          echo '<hr/>';
                      }
                      echo '</div>';
                    }
                  echo '</div>';
                echo '</div>';
              }
            }
          ?>
          <div id="modalImage">
            <div id="focusout"></div>
              <span id="closeModalImage"><i class="fa fa-times" aria-hidden="true"></i></span>
              <img class="modalImage-content" id="modalImageSrc" style="z-index:11;">
              <div id="caption"><?php echo $username; ?></div>
          </div>

          <div id="imagesMod">
            <span id="closeimagesMod"><i class="fa fa-times" aria-hidden="true"></i></span>

            <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <?php
                  for($i = 0; $i < count($imagesFetched); $i++){
                    if($i == 0){
                      echo '<li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>';
                    }else{
                      echo '<li data-target="#carouselIndicators" data-slide-to="'.$i.'"></li>';
                    }
                  }
                ?>
              </ol>
              <div class="carousel-inner">
              <?php
                $i = 0;
                foreach($imagesFetched as $val){
                  if($i == 0){
                    echo '<div class="carousel-item active">';
                      echo '<img class="d-block" src="'.$val["image"].'" width="85%" alt="post picture from '.$username.'">';
                      echo '<div class="carousel-caption d-none d-md-block">';
                        if($val['message'] != "NULL"){
                          echo '<p>'.$val['message'].'</p>';
                        }
                      echo '</div>';
                    echo '</div>';
                  }else{
                    echo '<div class="carousel-item">';
                      echo '<img class="d-block" src="'.$val["image"].'" width="85%" alt="post picture from '.$username.'">';
                      echo '<div class="carousel-caption d-none d-md-block">';
                        if($val['message'] != "NULL"){
                          echo '<p>'.$val['message'].'</p>';
                        }
                      echo '</div>';
                    echo '</div>';
                  }
                  $i = $i+1;
                }
              ?>
              </div>
              <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-3 ads" id="ads" style="padding-left:0px;">
          <h3>Sponsored</h3>
          <?php
            foreach($ads as $val){
              $adStalking = [];
              $adStalkers = 'SELECT COUNT(*) as stalkers FROM stalking WHERE stalked = "'.$val['name'].'";';
              $adStalkers = $conn->query($adStalkers);
              $adStalkers = $adStalkers->fetch(PDO::FETCH_ASSOC);
              array_push($adStalking, $val['name'], $adStalkers['stalkers']);

              echo '<div class="ad">';
                echo '<h5><a href="'.$val['link'].'">'.$val['name'].'</a></h5>';
                echo '<a href="'.$val['link'].'"><img src="'.$val['image'].'" width="100%" alt="'.$val['name'].'"></a>';
                echo '<p>'.$val['promo'].'</p>';
                echo '<p style="opacity:0.75;">'.$adStalking["1"].' people are stalking '.$val['name'].'</p>';
              echo '</div>';
            }
          ?>
        </div>
      </div>
      <hr/>
      <footer><p style="padding-bottom:15px;">© Butterfly Corp · Atlantiss 2020</p></footer>
    </div>

    <?php else: ?>
    <!-- SI L'UTILISATEUR N'EST PAS CONNECTÉ -->
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="alert alert-danger" style="margin-top:25%;text-align:center;" role="alert">
            <span>Connectez vous ou créez vous un compte pour pouvoir voir cette page.</span>
          </div>
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