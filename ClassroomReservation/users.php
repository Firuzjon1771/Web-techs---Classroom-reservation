<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';

if (isset($_SESSION['email'])){
  $user = getUser($_SESSION['email']);
  if (!str_contains( $user['role'],"useradmin")){
    header("Location: index.php?message=notallowed");
    exit();
  }
}
else{
    header("Location: index.php?message=notallowed");
    exit();
}

?>

<?php
$message = "";
if (isset($_GET['email'])) {
  $email = $_GET['email'];  
  $action= $_GET['action'];
  if ($action=="approve"){
    approveUser($email);
    $message = "User with Email ".$email." is approved.";
  }
  else{
    deleteUser($email);
    $message = "User with Email ".$email." is deleted.";
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


<!-- Users Container -->
<div class="w3-container" id="where" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Users</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p></p>
    
    <table border="1">
      <tr>
        <th>Username</th><th>Full name</th><th>Roles</th><th>Type</th><th>Approved</th>
      </tr>
      <?php
      $users = getUsers($user['department']);
      foreach ($users as $email => $u) {
        echo "<tr>";
        echo "<td>".$email."</td>";
        echo "<td>".$u['fullname']."</td>";
        echo "<td>".$u['role']."</td>";
        echo "<td>".$u['type']."</td>";
        if ($u['approved']=='1'){
          echo "<td><img src='images/tick.png'></td>";
        }
        else{
          ?>
          <td>
            <a href="users.php?action=approve&email=<?php echo $email;?>"><img src='images/tick.png' title='approve'></a>
             <a href="users.php?action=delete&email=<?php echo $email;?>"><img src='images/x.png' title='delete'></a>
          </form>
        </td>
        <?php
        }
        echo "</tr>";          
      }
      ?>
    </table>
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

