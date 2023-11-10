<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';

if (isset($_SESSION['email'])){

  $user = getUser($_SESSION['email']);
}

$message = "";
if (isset($_GET['message'])) {
  if ($_GET['message']=="login"){
    $message = "Welcome Back ".$user['fullname']."<br>Roles:".$user['role'].(str_contains( $user['role'],"teacher")?"<br>Type:".$user['type']:"");
  }
  else if($_GET['message']=="logout"){
    $message = "You are logged out of the system.";
  }
  else if($_GET['message']=="signup"){
    $message = "You are Signed up. To login you have to be approved by a users, admin.";
  }
  else if ($_GET['message']=="notallowed"){
    $message = "You were redirected here because you were not alloed to enter the page you visited.";
  }
}
?>
<!DOCTYPE html>
<html>
<?php include 'head.php';?>
<body>

<?php include 'links.php';?>


<?php include 'header.php';?>
<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">

<!-- About Container -->
<div class="w3-container" id="about">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide">
      <?php echo $message; ?>
    </span></h5>
    



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

