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
  $teaching = getTeaching($id);
  if ($teaching==false){
    header("Location: teachings.php?message=idnotfound");
    exit();
  }
}
else{
  header("Location: teachings.php?message=noid");
  exit();
}


if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $courseCode = $_POST['courseCode'];
  $course = $_POST['course'];
  $teacher = $_POST['teacher'];
  $type = $_POST['type'];
  $semester = $_POST['semester'];
  $hours = $_POST['hours'];
  updateTeaching($id,$courseCode,$course,$teacher,$type,$department,$semester,$hours);
  header("Location: teachings.php?message=updated");
  exit();
}
else if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  deleteTeaching($id);
  header("Location: teachings.php?message=deleted");
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
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Teaching</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p></p>
    <form action="" method="POST">
      <input type="hidden" name="id" value='<?php echo $id;?>'>
    <table border=1>
      <tr><th>Course Code</th><td><input class="w3-input w3-padding-16 w3-border" type="text" value="<?php echo $teaching['courseCode'];?>" required name="courseCode" <?php echo $isadmin?"":"disabled";?>></td></tr>
     <tr><th>Course</th><td><input class="w3-input w3-padding-16 w3-border" type="text" value="<?php echo $teaching['course'];?>" required name="course" <?php echo $isadmin?"":"disabled";?>></td></tr>
     <tr><th>Teacher</th><td>
       <p>
       
            <select id="teacher" name="teacher" <?php echo $isadmin?"":"disabled";?>>
            <?php
            
            $teachers = getTeachers($department);
            foreach ($teachers as $email => $t) {
                echo "<option value='".$email."'".($teaching['teacher']==$email?"selected":"").">".$t['fullname']."</option>";
            }
            ?>
        </select>
        
      </p>
      


     </td></tr>
      
      <tr>
        <th>Type</th>
        <td>
          <select id="type" name="type" <?php echo $isadmin?"":"disabled";?>>
            <option value='lab' <?php echo ($teaching['type']=="lab")?"selected":"";?>>lab</option>
            <option value='teaching' <?php echo ($teaching['type']=="theory")?"selected":"";?>>theory</option>    
        </select>
      </p>
        </td>
      </tr>
      <tr>
        <th>Semester</th>
        <td>
          <input class="w3-input w3-padding-16 w3-border" type="number" name="semester" min="1", max="12" value="<?php echo $teaching['semester'];?>" <?php echo $isadmin?"":"disabled";?>>
        </td>
      </tr>
      <tr>
        <th>Hours</th>
        <td>
          <input class="w3-input w3-padding-16 w3-border" type="number" name="hours" min="1", max="10" value="<?php echo $teaching['hours'];?>" <?php echo $isadmin?"":"disabled";?>>
        </td>
      </tr>
      <tr>
        <th>Department</th>
        <td>
          <select id="department" name="department" disabled>
            <?php
            $departments = getDepartments();
            foreach ($departments as $id => $name) {
               ?>
               <option value='$id' <?php echo ($teaching['department']==$id)?"selected":"";?>><?php echo $name;?></option>
            <?php 
            }
            ?>
        </select>
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

