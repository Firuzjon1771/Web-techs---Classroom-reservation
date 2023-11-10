<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';
if (isset($_SESSION['email'])){

  $user = getUser($_SESSION['email']);
  $fullname = $user['fullname'];
  $type = $_POST['type'];
}
?>


<?php
$message = "";
if (isset($_POST['update'])) {
  $email = $_SESSION['email'];
  $fullname = $_POST['fullname'];
  if (isset($_SESSION['email']) && str_contains( $user['role'],"teacher")){
    $type = $_POST['type'];
  }
  else{
    $type = NULL;
  }
  updateProfile($email,$fullname,$type);
  $message = "Your profile is updated.";

}
?>

<!DOCTYPE html>
<html>
<?php include 'head.php';?>
<body>

<?php include 'links.php';?>


<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">


<!-- profile Container -->
<div class="w3-container" id="where" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Profile</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p></p>
    <form action="" method="POST">
    <table border=1>
      <tr><th>Email</th><td><?php echo $user['email']; ?></td></tr>
     <tr><th>Roles</th><td><?php echo $user['role']; ?></td></tr>
     <tr><th>Fullname</th><td><input type="text" name="fullname" value = "<?php echo $fullname; ?>"></td></tr>
     <?php if (str_contains( $user['role'],"teacher")){ ?>
      <tr><th>Type</th>
        <td>
        
            <select id="type" name="type">
            <option value='lecturer' <?php echo ($type=='lecturer')?"selected":"";?>>lecturer</option>
            <option value='instructor' <?php echo ($type=='instructor')?"selected":"";?>>instructor</option>
            <option value='professor' <?php echo ($type=='professor')?"selected":"";?>>professor</option>
        </select>
      </td>
        </tr>
     <?php } ?>
    </table>
    <p><button class="w3-button w3-black" type="submit" name="update">UPDATE</button></p>
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

