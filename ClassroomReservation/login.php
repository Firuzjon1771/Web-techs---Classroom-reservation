<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';
$message = "";
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if (!checkEmail($email)){
    $message = "Email ".$email." not registered.";
  }
  else if (!checkPassword($email,$password)){
    $message = "Password for ".$email." not correct.";
  }
  else if (!checkApproved($email)){
    $message = "User with email ".$email." not approved yet.";
  }
  else{
    $_SESSION['email'] = $email;
    header("Location: index.php?message=login");
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<?php include 'head.php';?>
<body>

<?php include 'links.php';?>


<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">


<!-- Login Container -->
<div class="w3-container" id="where" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Login</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p>If you are not registered, please <a href="signup.php">signup</a> first.</p>
    
    <form action="" method="POST">
      <p><input class="w3-input w3-padding-16 w3-border" type="email" placeholder="email" required name="email"></p>
      <p><input class="w3-input w3-padding-16 w3-border" type="password" placeholder="password" required name="password"></p>
      <p><button class="w3-button w3-black" type="submit" name="login">LOGIN</button></p>
    </form>
  </div>
</div>

<!-- End page content -->
</div>

<?php include 'footer.php';?>

<script>
// Tabbed Menu
function openMenu(evt, menuName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("menu");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-dark-grey", "");
  }
  document.getElementById(menuName).style.display = "block";
  evt.currentTarget.firstElementChild.className += " w3-dark-grey";
}
document.getElementById("myLink").click();
</script>

</body>
</html>

