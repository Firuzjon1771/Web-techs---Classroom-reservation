<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s2">
      <a href="index.php" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <?php if (isset($_SESSION['email']) && str_contains( $user['role'],"useradmin")){ ?>
    <div class="w3-col s2">
      <a href="users.php" class="w3-button w3-block w3-black">USERS</a>
    </div>

  <?php } ?>
    <div class="w3-col s2">
      <a href="classrooms.php" class="w3-button w3-block w3-black">CLASSROOMS</a>
    </div>
     <?php if (isset($_SESSION['email']) && (str_contains( $user['role'],"teacher")|| (str_contains( $user['role'],"reservationadmin")))){ ?>
    <div class="w3-col s2">
      <a href="reservations.php" class="w3-button w3-block w3-black">RESERVATIONS</a>
    </div>
    <?php } ?>
    <?php if (isset($_SESSION['email']) && (str_contains( $user['role'],"teacher")|| (str_contains( $user['role'],"reservationadmin")))){ ?>
    <div class="w3-col s2">
      <a href="teachings.php" class="w3-button w3-block w3-black">TEACHINGS</a>
    </div>

  <?php } ?>
  <?php if (!isset($_SESSION['email'])){ ?>
    <div class="w3-col s2">
      <a href="login.php" class="w3-button w3-block w3-black">LOGIN</a>
    </div>
  <?php } ?>
  <?php if (!isset($_SESSION['email'])){ ?>
    <div class="w3-col s2">
      <a href="signup.php" class="w3-button w3-block w3-black">SIGNUP</a>
    </div>
  <?php } ?>
  <?php if (isset($_SESSION['email'])){ ?>
    <div class="w3-col s2">
      <a href="profile.php" class="w3-button w3-block w3-black" ><?php echo $_SESSION['email'];?></a>
    </div>
    <div class="w3-col s2">
      <a href="logout.php" class="w3-button w3-block w3-black">LOGOUT </a>
    </div>
    <?php } ?>
  </div>
</div>
