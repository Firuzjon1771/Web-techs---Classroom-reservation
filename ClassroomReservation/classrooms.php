<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';

if (isset($_SESSION['email'])){
  $user = getUser($_SESSION['email']);
  
}
?>

<?php
$message = "";
if (isset($_POST['search'])) {
  $term = $_POST['term'];  
  $classrooms = getClassroomsTerm($term);
  $message = "Classrooms with ".$term." in building or address.";
}
else{
  $classrooms = getClassrooms();
}
if (isset($_GET['message'])) {
  if ($_GET['message']=="noid"){
    $message = 'You must select a specific classroom to view details.';

    }
    else if ($_GET['message']=="idnotfound"){
      $message = 'No classroom with given id exists.';
    }
    else if ($_GET['message']=="deleted"){
      $message = 'Classroom deleted.';
    }
    else if ($_GET['message']=="updated"){
      $message = "Classroom is updated.";
    }
  }
  if (isset($_POST['upload'])) {
     if (isset($_FILES["file"])){
      $handle = fopen($_FILES['file']['tmp_name'], "r");
      
     $headers = fgetcsv($handle, 1000, ";");
     $count=0;
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) 
    {
      
      insertClassroom($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],
        $data[7],$data[8]);
      $count++;
    }
    $classrooms = getClassrooms();
    $message = 'File uploaded. '.$count.' classrooms added.';
    fclose($handle);
  }
  else{
    $message = 'File not selected. ';
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


<!-- Classrooms Container -->
<div class="w3-container" id="where" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Classrooms</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p>
      <form action="" method="POST">
        <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="search term" required name="term"></p>
      <p><button class="w3-button w3-black" type="submit" name="search">SEARCH</button></p>
    </form>

    </p>
    
    <table border="1">
      <tr>
        <th>Building</th><th>Address</th><th>Capacity</th><th>More</th>
      </tr>
      <?php
      
      foreach ($classrooms as $id => $c) {
        echo "<tr>";
        echo "<td>".$c['building']."</td>";
        echo "<td>".$c['address']."</td>";
        echo "<td>".$c['capacity']."</td>";
        echo "<td><a href='classroom.php?id=".$id."'><img src='images/classroom.png'></a></td>";
        echo "</tr>";        
      }
      if (isset($_SESSION['email']) && str_contains( $user['role'],"reservationadmin")){ ?>
        <tr><td></td><td>
          <form method="POST" action="" enctype="multipart/form-data">
        <label >Upload File:</label>
        <input type="file" name="file" accept=".csv" required>
        <button class="w3-button w3-black" type="submit" name="upload">UPLOAD</button>
    </form>
        </td><td></td><td><a href='classroomadd.php'><img src='images/add.png' title='add classroom.'></a></td>
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

