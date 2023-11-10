<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';

if (isset($_SESSION['email'])){
  $user = getUser($_SESSION['email']);
  $department = $user['department'];
  if (!str_contains( $user['role'],"reservationadmin")){
    header("Location: index.php?message=notallowed");
    exit();
  }
}
else{
    header("Location: index.php?message=notallowed");
    exit();
}

// form submited
$message = "";
if (isset($_POST['add'])) {
    
    $teachingID = $_POST['teaching'];
    $teaching = getTeaching($teachingID);
    $teacher = $teaching['teacher'];
    $classroom = $_POST['classroom'];
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $duration = $_POST['duration'];
    
    
    if (insertReservation($teachingID,$teacher,$classroom,$day,$hour,$duration)){
      $message = "Reservation inserted.";
    }
    else{
      $message = "Classroom not available.";
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
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Add Reservation</span></h5>
    <p style='color:red'><?php echo $message; ?></p>

    
    <form action="" method="POST">
      <p>
        Select Teaching:
        
            <select id="teaching" name="teaching">
            <?php
            
            $teachings = getTeachings($department);
            foreach ($teachings as $id => $t) {
                echo "<option value='".$id."'>".$t['courseCode']." ".$t['course']." ".$t['teachername']."</option>";
            }
            ?>
        </select>
        
      </p>
      <p>
        Select Classroom:
        
            <select name="classroom" onchange="toggleTable(this.value)">
            <?php
            
            $classrooms = getClassrooms();
            foreach ($classrooms as $id => $c) {
                echo "<option value='".$id."'>".$c['building']."</option>";
            }
            ?>
        </select>
        
      </p>
      <?php 
        $days = array('Monday','Tuesday','Wednesday','Thursday','Friday');
        $hours = array('09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00');?>
      <?php 

      foreach ($classrooms as $id => $c) {
        ?>
        <table border=1 display="none" class="classroom" id="<?php echo $id;?>">
          <tr><th></th>
            <?php 
            foreach ($days as $day) {

              echo "<th>".$day."</th>";
            }
              ?>
          </tr>
          <?php 
            foreach ($hours as $hour) {
              echo "<tr>";
              echo "<th>".$hour."</th>";
              foreach ($days as $day){
                echo "<td style='text-align: center;'>";
                if (!availableClassroom($id,$day,$hour)){
                  echo 'X';
                }
                else{
                  $booked = bookedClassroom($id,$day,$hour);
                  if ($booked!=false){
                    echo $booked;
                  }
                  
                }
                echo "</td>";
              }
              echo "</tr>";
            }
          ?>
        </table>
      <?php } ?>
      <p>
        <label >Hour:</label>
        <select name="hour" required>
          <option value="09:00">09:00</option>
          <option value="10:00">10:00</option>
          <option value="11:00">11:00</option>
          <option value="12:00">12:00</option>
          <option value="13:00">13:00</option>
          <option value="14:00">14:00</option>
          <option value="15:00">15:00</option>
          <option value="16:00">16:00</option>
          <option value="17:00">17:00</option>
          <option value="18:00">18:00</option>
          <option value="19:00">19:00</option>
          <option value="20:00">20:00</option>
          <option value="21:00">21:00</option>
        </select>

      </p>
      <p>
        <label >Day:</label>
        <select name="day" required>
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          
        </select>

      </p>
      
      <p><label>Duration</label><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="duration" name="duration" min="1", max="3" value="3"></p>
      
      <p><button class="w3-button w3-black" type="submit" name="add">ADD</button></p>
    </form>
  </div>
</div>

<!-- End page content -->
</div>

<?php include 'footer.php';?>
<script>

        // JavaScript function to toggle the visibility of tables
        function toggleTable(classroomId) {
            var tables = document.getElementsByClassName('classroom');
            
            // Hide all
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.display = 'none';
            }
            
            // Show the selected table
            var selectedTable = document.getElementById(classroomId);
            if (selectedTable) {
                selectedTable.style.display = 'table'; // Display the table
            }
        }
        window.onload = function() {
          toggleTable(1);
        }
    </script>
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

