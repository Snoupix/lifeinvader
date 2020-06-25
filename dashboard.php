<?php
  session_start();
  require 'database.php';
  date_default_timezone_set('Europe/Paris');

  if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
  }else if(isset($_GET['username'])){
    $username = $_GET['username'];
  }
  
  try{

    // SQL QUERYS

    $adReq = 'SELECT * FROM ads ORDER BY RAND()';
    $allPosts = 'SELECT * FROM post';
    $allUsers = 'SELECT * FROM user';
    $stalkReq = 'SELECT stalked FROM stalking WHERE usernameFK = "'.$username.'"';
    $likesReq = 'SELECT * FROM likes';
    $plusLike = 'INSERT INTO likes VALUES (:id, :wholiked);';
    $unLike = 'DELETE FROM likes WHERE id = :id AND userWhoLike = :user ;';
    


    $adReq = $conn->query($adReq);
    $ads = $adReq->fetchAll(PDO::FETCH_ASSOC);

    $allPosts = $conn->query($allPosts);
    $allPosts = $allPosts->fetchAll(PDO::FETCH_ASSOC);

    $allUsers = $conn->query($allUsers);
    $allUsers = $allUsers->fetchAll(PDO::FETCH_ASSOC);

    $stalkReq = $conn->query($stalkReq);
    $stalkReq = $stalkReq->fetchAll(PDO::FETCH_ASSOC);
    
    $likesReq = $conn->query($likesReq);
    $allLikes = $likesReq->fetchAll(PDO::FETCH_ASSOC);
    


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
  <meta property="og:url"            content="https://www.domain.com/index.php" />
  <meta property="og:type"           content="website" />
  <meta property="og:title"          content="Lifeinvader Atlantiss" />
  <meta property="og:description"    content="Le réseau social du serveur GTA RP Atlantiss. Discord : https://discord.gg/w5HBjWw" />
  <meta property="og:image"          content="./assets/img/favicon.ico" />

  <title>Lifeinvader</title>

  <link rel="stylesheet" href="./assets/css/header.css">
  <link rel="stylesheet" href="./assets/css/dashboard.css">
  <link rel="stylesheet" href="./assets/css/index.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link rel="shortcut icon" href="./assets/img/favicon.ico">
</head>
<body>
  <?php require('header.php'); ?>
  <?php if(empty($_SESSION['username'])): ?> <!-- If disconnected -->

    <div class="container">
      <div class="row">
        <div class="col-9 posts">
          <?php
            $reversedArray = array_reverse($allPosts, true);
            foreach($reversedArray as $key){
              foreach($allUsers as $user){
                if($user['username'] == $key['usernameFK']){
                  $userPost = $user;
                }
              }
              $i = 0;
              foreach($allLikes as $like){
                if($like['id'] == $key['id']){
                  $i = $i+1;
                }
                $likeCount = $i;
              }
              if($key['image'] != 'NULL' && $key['message'] != "NULL"){ // Post text avec image
                echo '<div class="post">';
                  echo '<div class="postBanner">';
                    echo '<img src="'.$userPost['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                    echo '<a href="index.php?username='.$userPost['username'].'">'.$key['usernameFK'].'</a>';
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
                    echo '<button style="border:none;background:none;outline:none;cursor:default;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                  echo '</div>';
                echo '</div>';
              }
              if($key['image'] == "NULL" && $key['message'] != "NULL"){ // Post text sans image
                $i = 0;
                foreach($allLikes as $like){
                  if($like['id'] == $key['id']){
                    $i = $i+1;
                  }
                  $likeCount = $i;
                }
                echo '<div class="post">';
                  echo '<div class="postBanner">';
                    echo '<img src="'.$userPost['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                    echo '<a href="index.php?username='.$userPost['username'].'">'.$key['usernameFK'].'</a>';
                    echo '<span>Posté '.$key['date'].'</span>';
                    echo '<hr/>';
                  echo '</div>';
                  echo '<div class="postContent">';
                    echo '<p>'.$key['message'].'</p>';
                  echo '</div>';
                  echo '<div class="postFooter">';
                    echo '<hr style="margin-top: 0.5rem;margin-bottom: 0.5rem;" />';
                    echo '<button style="border:none;background:none;outline:none;cursor:default;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                  echo '</div>';
                echo '</div>';
              }
              if($key['message'] == "NULL"){ // Post avec image seule
                $i = 0;
                foreach($allLikes as $like){
                  if($like['id'] == $key['id']){
                    $i = $i+1;
                  }
                  $likeCount = $i;
                }
                echo '<div class="post">';
                  echo '<div class="postBanner">';
                    echo '<img src="'.$userPost['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                    echo '<a href="index.php?username='.$userPost['username'].'">'.$key['usernameFK'].'</a>';
                    echo '<span>Posté '.$key['date'].'</span>';
                    echo '<hr/>';
                  echo '</div>';
                  echo '<div class="postImage">';
                    echo '<img src="'.$key['image'].'" alt="Post Picture" width="50%"/>';
                  echo '</div>';
                  echo '<div class="postFooter">';
                    echo '<hr/>';
                    echo '<button style="border:none;background:none;outline:none;cursor:default;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
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
        </div>
        <div class="col-3 ads">
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
                echo '<p>'.$adStalking["1"].' people are stalking '.$val['name'].'</p>';
              echo '</div>';
            }
          ?>
        </div>
      </div>
    </div>

  <?php else: ?> <!-- If connected -->
  <form id="filterForm" method="POST" action="dashboard.php">
    <select class="btn btn-sm btn-dark" name="filter" id="filter">
      <option value="all">Tout voir</option>
      <option value="stalked">Voir les personnes stalked</option>
    </select>
    <input type="hidden" name="value">
  </form>

  <div class="container">
    <div class="row">
      <div class="col-9 posts" style="margin-top:5%;">
        <?php
          $stalkingArray = [];
          foreach($stalkReq as $stalk){
            array_push($stalkingArray, $stalk['stalked']);
          }

          $reversedArray = array_reverse($allPosts, true);

          foreach($reversedArray as $key){
            foreach($allUsers as $user){
              if($user['username'] == $key['usernameFK']){
                $userPost = $user;
              }
            }

            $stalking = (in_array($key['usernameFK'], $stalkingArray)) ? '' : ' notStalking';

            if($key['image'] != 'NULL' && $key['message'] != "NULL"){ // Post text avec image
              $i = 0;
              $yetLiked = false;
              foreach($allLikes as $like){
                if($like['id'] == $key['id']){
                  $i = $i+1;
                }
                if($like['userWhoLike'] == $_SESSION['username'] && $key['id'] == $like['id']){
                  $yetLiked = true;
                }
                $likeCount = $i;
              }
              echo '<div class="post'.$stalking.'">';
                echo '<div class="postBanner">';
                  echo '<img src="'.$userPost['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                  echo '<a href="index.php?username='.$userPost['username'].'">'.$key['usernameFK'].'</a>';
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
                    echo '</form>';
                  }else{
                    echo '<form class="formLike" method="POST">';
                      echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                      echo '<button name="likePost" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                    echo '</form>';
                  }
                echo '</div>';
              echo '</div>';
            }
            if($key['image'] == "NULL" && $key['message'] != "NULL"){ // Post text sans image
              $i = 0;
              $yetLiked = false;
              foreach($allLikes as $like){
                if($like['id'] == $key['id']){
                  $i = $i+1;
                }
                if($like['userWhoLike'] == $_SESSION['username'] && $key['id'] == $like['id']){
                  $yetLiked = true;
                }
                $likeCount = $i;
              }
              echo '<div class="post'.$stalking.'">';
                echo '<div class="postBanner">';
                  echo '<img src="'.$userPost['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                  echo '<a href="index.php?username='.$userPost['username'].'">'.$key['usernameFK'].'</a>';
                  echo '<span>Posté '.$key['date'].'</span>';
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
                    echo '</form>';
                  }else{
                    echo '<form class="formLike" method="POST">';
                      echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                      echo '<button name="likePost" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                    echo '</form>';
                  }
                echo '</div>';
              echo '</div>';
            }
            if($key['message'] == "NULL"){ // Post avec image seule
              $i = 0;
              $yetLiked = false;
              foreach($allLikes as $like){
                if($like['id'] == $key['id']){
                  $i = $i+1;
                }
                if($like['userWhoLike'] == $_SESSION['username'] && $key['id'] == $like['id']){
                  $yetLiked = true;
                }
                $likeCount = $i;
              }
              echo '<div class="post'.$stalking.'">';
                echo '<div class="postBanner">';
                  echo '<img src="'.$userPost['avatar'].'" alt="Profile Picture" draggable="false" width="65px"/>';
                  echo '<a href="index.php?username='.$userPost['username'].'">'.$key['usernameFK'].'</a>';
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
                    echo '</form>';
                  }else{
                    echo '<form class="formLike" method="POST">';
                      echo '<input name="idLiked" type="hidden" value="'.$key['id'].'" />';
                      echo '<button name="likePost" type="submit" style="border:none;background:none;outline:none;"><i class="fas fa-heart"></i></button><span> Likes '.$likeCount.'</span>';
                    echo '</form>';
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
      </div>
      <div class="col-3 ads">
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
              echo '<p>'.$adStalking["1"].' people are stalking '.$val['name'].'</p>';
            echo '</div>';
          }
        ?>
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