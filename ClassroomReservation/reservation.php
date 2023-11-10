<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';
$isadmin = false;
if (isset($_SESSION['email'])){

  $user = getUser($_SESSION['email']);
  if (str_contains( $user['role'],"reservationadmin")){
    $isadmin = true;
  }
  $fullname = $user['fullname'];
  $department = $user['department'];
}
$message = "";
if (isset($_GET['id'])){
  $id = $_GET['id'];
  $reservation = getReservation($id);
  if ($reservation==false){
    header("Location: reservations.php?message=idnotfound");
    exit();
  }
}
else{
  header("Location: reservations.php?message=noid");
  exit();
}


if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $classroom = $_POST['classroom'];
  $day = $_POST['day'];
  $hour = $_POST['hour'];
  $duration = $_POST['duration'];
  if (updateReservation($id,$classroom,$day,$hour,$duration)){
    header("Location: reservations.php?message=updated");
    exit();
  }
  else{
    $message = "Update not applicable.";
  }
}
else if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  deleteReservation($id);
  header("Location: reservations.php?message=deleted");
  exit();
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
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Reservation</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p></p>
    <form action="" method="POST">
      <input type="hidden" name="id" value='<?php echo $id;?>'>
    <table border=1>
      <tr><th>Course Code</th><td><?php echo $reservation['courseCode']; ?></td></tr>
     <tr><th>Course</th><td><?php echo $reservation['course'];?></td></tr>
     <tr><th>Teacher</th><td><?php echo $reservation['teachername'];?></td></tr>
     <tr><th>Classroom</th><td>
       <select name="classroom" onchange="toggleTable(this.value)" <?php echo $isadmin?"":"disabled";?>>
            <?php
            
            $classrooms = getClassrooms();
            foreach ($classrooms as $id => $c) {
                echo "<option value='".$id."' ".($reservation['classroom']==$id?'selected':'').">".$c['building']."</option>";
            }
            ?>
        </select>

     </td></tr>
      <tr><th>Day:</th>
        <td>
        
        <select name="day" required <?php echo $isadmin?"":"disabled";?>>
          <option value="Monday" <?php echo ($reservation['day']=="Monday"?"selected":"");?>>Monday</option>
          <option value="Tuesday" <?php echo ($reservation['day']=="Tuesday"?"selected":"");?>>Tuesday</option>
          <option value="Wednesday" <?php echo ($reservation['day']=="Wednesday"?"selected":"");?>>Wednesday</option>
          <option value="Thursday" <?php echo ($reservation['day']=="Thursday"?"selected":"");?>>Thursday</option>
          <option value="Friday" <?php echo ($reservation['day']=="Friday"?"selected":"");?>>Friday</option>
        </select>
        </td>
      </tr>
      
      <tr><th>Hour:</th>
        <td>
        
        <select name="hour" required <?php echo $isadmin?"":"disabled";?>>
          <option value="09:00" <?php echo str_starts_with($reservation['hour'],"09:00")?"selected":"";?>>09:00</option>
          <option value="10:00" <?php echo str_starts_with($reservation['hour'],"10:00")?"selected":"";?>>10:00</option>
          <option value="11:00" <?php echo str_starts_with($reservation['hour'],"11:00")?"selected":"";?>>11:00</option>
          <option value="12:00" <?php echo str_starts_with($reservation['hour'],"12:00")?"selected":"";?>>12:00</option>
          <option value="13:00" <?php echo str_starts_with($reservation['hour'],"13:00")?"selected":"";?>>13:00</option>
          <option value="14:00" <?php echo str_starts_with($reservation['hour'],"14:00")?"selected":"";?>>14:00</option>
          <option value="15:00" <?php echo str_starts_with($reservation['hour'],"15:00")?"selected":"";?>>15:00</option>
          <option value="16:00" <?php echo str_starts_with($reservation['hour'],"16:00")?"selected":"";?>>16:00</option>
          <option value="17:00" <?php echo str_starts_with($reservation['hour'],"17:00")?"selected":"";?>>17:00</option>
          <option value="18:00" <?php echo str_starts_with($reservation['hour'],"18:00")?"selected":"";?>>18:00</option>
          <option value="19:00" <?php str_starts_with($reservation['hour'],"19:00")?"selected":"";?>>19:00</option>
          <option value="20:00" <?php echo str_starts_with($reservation['hour'],"20:00")?"selected":"";?>>20:00</option>
          <option value="21:00" <?php echo str_starts_with($reservation['hour'],"21:00")?"selected":"";?>>21:00</option>
        </select>
      </td>
        </tr>
        
        <th>Duration</th>
        <td>
          <input class="w3-input w3-padding-16 w3-border" type="number" name="duration" min="1", max="10" value="<?php echo $reservation['duration'];?>" <?php echo $isadmin?"":"disabled";?>>
        </td>
      </tr>
      
      
    </table>
    <?php if ($isadmin){ ?>
    <p>

      <button class="w3-button w3-black" type="submit" name="update">UPDATE</button>
      <button class="w3-button w3-black" type="submit" name="delete">DELETE</button>
    </p>
  <?php } ?>
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

