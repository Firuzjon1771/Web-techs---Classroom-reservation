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
  $type = $_POST['type'];
}
$message = "";
if (isset($_GET['id'])){
  $id = $_GET['id'];
  $classroom = getClassroom($_GET['id']);
  if ($classroom==false){
    header("Location: classrooms.php?message=idnotfound");
    exit();
  }
}
else{
  header("Location: classrooms.php?message=noid");
  exit();
}


if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $building = $_POST['building'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];
    $hourlyAvailability = implode(",", $_POST['hourlyAvailability']);
    $dailyAvailability = implode(",", $_POST['dailyAvailability']);
    $type = $_POST['type'];
    if ($type=='lab')
      $computers = $_POST['computers'];
    else
      $computers = 0;
    if (isset($_POST['projector']))
      $projector = 1;
    else
      $projector = 0;
    if (isset($_POST['locked']))
      $locked = 1;
    else
      $locked = 0;
  updateClassroom($id,$building,$address,$capacity,$hourlyAvailability,$dailyAvailability,$type,$computers,$projector,$locked);
  header("Location: classrooms.php?message=updated");
  exit();
}
else if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  deleteClassroom($id);
  header("Location: classrooms.php?message=deleted");
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
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Classroom</span></h5>
    <p style='color:red'><?php echo $message; ?></p>
    <p></p>
    <form action="" method="POST">
      <input type="hidden" name="id" value='<?php echo $id;?>'>
    <table border=1>
      <tr><th>Building</th><td><input class="w3-input w3-padding-16 w3-border" type="text" value="<?php echo $classroom['building'];?>" required name="building" <?php echo $isadmin?"":"disabled";?>></td></tr>
     <tr><th>Address</th><td><input class="w3-input w3-padding-16 w3-border" type="text" value="<?php echo $classroom['address'];?>" required name="address" <?php echo $isadmin?"":"disabled";?>></td></tr>
     <tr><th>Capacity</th><td><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="capacity" name="capacity" min="10", max="200" value="<?php echo $classroom['capacity'];?>" <?php echo $isadmin?"":"disabled";?>></td></tr>
      <tr><th>Hourly Availability:</th>
        <td>
        
        <select name="hourlyAvailability[]" multiple required <?php echo $isadmin?"":"disabled";?>>
          <option value="09:00" <?php echo str_contains( $classroom['hourlyAvailability'],"09:00")?"selected":"";?>>09:00</option>
          <option value="10:00" <?php echo str_contains( $classroom['hourlyAvailability'],"10:00")?"selected":"";?>>10:00</option>
          <option value="11:00" <?php echo str_contains( $classroom['hourlyAvailability'],"11:00")?"selected":"";?>>11:00</option>
          <option value="12:00" <?php echo str_contains( $classroom['hourlyAvailability'],"12:00")?"selected":"";?>>12:00</option>
          <option value="13:00" <?php echo str_contains( $classroom['hourlyAvailability'],"13:00")?"selected":"";?>>13:00</option>
          <option value="14:00" <?php echo str_contains( $classroom['hourlyAvailability'],"14:00")?"selected":"";?>>14:00</option>
          <option value="15:00" <?php echo str_contains( $classroom['hourlyAvailability'],"15:00")?"selected":"";?>>15:00</option>
          <option value="16:00" <?php echo str_contains( $classroom['hourlyAvailability'],"16:00")?"selected":"";?>>16:00</option>
          <option value="17:00" <?php echo str_contains( $classroom['hourlyAvailability'],"17:00")?"selected":"";?>>17:00</option>
          <option value="18:00" <?php echo str_contains( $classroom['hourlyAvailability'],"18:00")?"selected":"";?>>18:00</option>
          <option value="19:00" <?php echo str_contains( $classroom['hourlyAvailability'],"19:00")?"selected":"";?>>19:00</option>
          <option value="20:00" <?php echo str_contains( $classroom['hourlyAvailability'],"20:00")?"selected":"";?>>20:00</option>
          <option value="21:00" <?php echo str_contains( $classroom['hourlyAvailability'],"21:00")?"selected":"";?>>21:00</option>
        </select>
      </td>
        </tr>
        <tr><th>Daily Availability:</th>
        <td>
        
        <select name="dailyAvailability[]" multiple required <?php echo $isadmin?"":"disabled";?>>
          <option value="Monday" <?php echo str_contains( $classroom['dailyAvailability'],"Monday")?"selected":"";?>>Monday</option>
          <option value="Tuesday" <?php echo str_contains( $classroom['dailyAvailability'],"Tuesday")?"selected":"";?>>Tuesday</option>
          <option value="Wednesday" <?php echo str_contains( $classroom['dailyAvailability'],"Wednesday")?"selected":"";?>>Wednesday</option>
          <option value="Thursday" <?php echo str_contains( $classroom['dailyAvailability'],"Thursday")?"selected":"";?>>Thursday</option>
          <option value="Friday" <?php echo str_contains( $classroom['dailyAvailability'],"Friday")?"selected":"";?>>Friday</option>
        </select>
        </td>
      </tr>
      <tr>
        <th>Type</th>
        <td>
          <select id="type" name="type" <?php echo $isadmin?"":"disabled";?>>
            <option value='lab' <?php echo ($classroom['type']=="lab")?"selected":"";?>>lab</option>
            <option value='teaching' <?php echo ($classroom['type']=="teaching")?"selected":"";?>>teaching</option>    
        </select>
      </p>
        </td>
      </tr>
      <tr>
        <th>Computers</th>
        <td>
          <input class="w3-input w3-padding-16 w3-border" type="number" name="computers" min="0", max="200" value="<?php echo $classroom['computers'];?>" <?php echo $isadmin?"":"disabled";?>>
        </td>
      </tr>
      <tr>
        <th>Projector</th>
        <td>
          <input class="w3-input w3-padding-16 w3-border" type="checkbox" name="projector" <?php echo $classroom['projector']==0?"":"checked";?> <?php echo $isadmin?"":"disabled";?>>
        </td>
      </tr>
      <tr>
        <th>Locked</th>
        <td>
          <input class="w3-input w3-padding-16 w3-border" type="checkbox"  name="locked" <?php echo $classroom['projector']==0?"":"checked";?> <?php echo $isadmin?"":"disabled";?>>
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

