<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';

if (isset($_SESSION['email'])){
  $user = getUser($_SESSION['email']);
  if (!(str_contains( $user['role'],"teacher")|| (str_contains( $user['role'],"reservationadmin")))){
    header("Location: index.php?message=notallowed");
    exit();
  }
}
?>

<?php
$message = "";
$teachings = getTeachings($user['department']);

if (isset($_GET['message'])) {
  if ($_GET['message']=="noid"){
    $message = 'You must select a specific teaching to view details.';

    }
    else if ($_GET['message']=="idnotfound"){
      $message = 'No teaching with given id exists.';
    }
    else if ($_GET['message']=="deleted"){
      $message = 'Teaching deleted.';
    }
    else if ($_GET['message']=="updated"){
      $message = "Teaching is updated.";
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


<!-- Teachings Container -->
<div class="w3-container" id="where" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Teachings</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    
    
    <table border="1">
      <tr>
        <th>course Code</th><th>course</th><th>teacher</th><th>More</th>
      </tr>
      <?php
      
      foreach ($teachings as $id => $t) {
        echo "<tr>";
        echo "<td>".$t['courseCode']."</td>";
        echo "<td>".$t['course']."</td>";
        echo "<td>".$t['teachername']."</td>";
        echo "<td><a href='teaching.php?id=".$id."'><img src='images/classroom.png'></a></td>";
        echo "</tr>";        
      }
      if (isset($_SESSION['email']) && str_contains( $user['role'],"reservationadmin")){ ?>
        <tr><td></td><td>
          
        </td><td></td><td><a href='teachingadd.php'><img src='images/add.png' title='add teaching.'></a></td>
          <?php
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

