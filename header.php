<div id="searchMod" class="closedSearch">
  <form action="index.php" method="get">
    <input name="username" id="searchBar" type="text" placeholder="Nom d'utilisateur à rechercher" size="40">
    <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;" tabindex="-1" />
  </form>
</div>
<nav>
  <section class="container">
    <div class="row">
      <div class="col">
        <a id="logo" href="dashboard.php"></a>
        <?php if(!empty($_SESSION['username'])): ?>
        <div class="profileButton">
          <a href="index.php"><i class="far fa-user-circle"></i></a>
        </div>
        <?php endif; ?>
      </div>
      <?php if(empty($_SESSION['username'])): ?>
      <div id="signinButton" class="col">
        <a class="btn btn-dark float-right" href="signin.php">Connexion</a>
      </div>
      <?php endif; ?>
      <?php if(!empty($_SESSION['username'])): ?>
      <div id="signinButton" class="col">
        <div id="search"><i class="fa fa-search"></i></div>
        <a class="btn btn-dark float-right" href="signout.php">Déconnexion</a>
      </div>
      <?php endif; ?>
    </div>
  </section>
</nav>