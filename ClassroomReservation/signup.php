<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';
// form submited
$message = "";
if (isset($_POST['signup'])) {
  $email = $_POST['email'];
  if (checkEmail($email)){
    $message = "Email ".$email." is already registered.";
  }
  else if (!isset($_POST['roles'])) {
    $message = "You must select at least one role.";
  }
  else{
    $password = $_POST['password'];
    $roles = implode(",", $_POST['roles']);
    $department = $_POST['department'];
    $fullname = $_POST['fullname'];
    if (str_contains( $roles,"teacher"))
      $type = $_POST['type'];
    else{
      $type = NULL;
    }
    insertUser($email, $password, $fullname, $roles, $department, $type);
    header("Location: index.php?message=signup");
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


<!-- Sign up Container -->
<div class="w3-container" id="where" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Sign Up</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p>If you are already registered, please <a href="login.php">login</a>.</p>
    
    <form action="" method="POST">
      <p><input class="w3-input w3-padding-16 w3-border" type="email" placeholder="email" required name="email"></p>
      <p><input class="w3-input w3-padding-16 w3-border" type="password" placeholder="password" required name="password"></p>
      <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="full name" required name="fullname"></p>
      <p>
        Select Department:
        <select id="department" name="department">
            <?php
            $departments = getDepartments();
            foreach ($departments as $id => $name) {
                echo "<option value='$id'>".$name."</option>";
            }
            ?>
        </select>
      </p>
      Select Role(s):
        <label><input type="checkbox" name="roles[]" value="useradmin"> User Admin</label>
        <label><input type="checkbox" name="roles[]" value="reservationadmin"> Reservation Admin</label>
        <label><input type="checkbox" name="roles[]" value="teacher"> Teacher</label>
      <p>
        Teacher type:
        <select id="type" name="type">
            <option value='lecturer'>lecturer</option>
            <option value='instructor'>instructor</option>
            <option value='professor'>professor</option>
        </select>
      </p>
      <p><button class="w3-button w3-black" type="submit" name="signup">SIGNUP</button></p>
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

