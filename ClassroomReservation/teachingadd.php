<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';
$department = 0;
if (isset($_SESSION['email'])){
  $user = getUser($_SESSION['email']);
  if (!str_contains( $user['role'],"reservationadmin")){
    header("Location: index.php?message=notallowed");
    exit();
  }
  $department = $user['department'];
}
else{
    header("Location: index.php?message=notallowed");
    exit();
}

// form submited
$message = "";
if (isset($_POST['add'])) {
  
    $courseCode = $_POST['courseCode'];
    $course = $_POST['course'];
    $teacher = $_POST['teacher'];
    $type = $_POST['type'];
    $semester = $_POST['semester'];
    $hours = $_POST['hours'];
    
    insertTeaching($courseCode,$course,$teacher,$type,$department,$semester,$hours);
    $message = "Teaching inserted.";
  
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
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Add Teaching</span></h5>
    <p style='color:red'><?php echo $message; ?></p>

    
    <form action="" method="POST">
      <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="course code" required name="courseCode"></p>
      <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="course name" required name="course"></p>
      <p>
        Select Teacher:
        
            <select id="teacher" name="teacher">
            <?php
            
            $teachers = getTeachers($department);
            foreach ($teachers as $email => $t) {
                echo "<option value='".$email."'>".$t['fullname']."</option>";
            }
            ?>
        </select>
        
      </p>
      
      <p>
        Type:
        <select id="type" name="type">
            <option value='lab'>lab</option>
            <option value='teaching'>teaching</option>    
        </select>
      </p>
      <p><label>Semester</label><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="semester" name="semester" min="1", max="12" value="1"></p>
      <p><label>Hours</label><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="hours" name="hours" min="1", max="8" value="2"></p>
      
      <p><button class="w3-button w3-black" type="submit" name="add">ADD</button></p>
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

