<?php 
// Session for login system. First statement in every page
session_start();
// Database functions
include 'db.php';

if (isset($_SESSION['email'])){
  $user = getUser($_SESSION['email']);
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
    
    insertClassroom($building,$address,$capacity,$hourlyAvailability,$dailyAvailability,$type,$computers,$projector,$locked);
    $message = "Classroom inserted.";
  
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
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">Add Classroom</span></h5>
    <p style='color:red'><?php echo $message; ?></p>

    
    <form action="" method="POST">
      <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="building" required name="building"></p>
      <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="address" required name="address"></p>
      <p><label>Capacity</label><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="capacity" name="capacity" min="10", max="200" value="50"></p>
      <p>
        <label >Hourly Availability:</label>
        <select name="hourlyAvailability[]" multiple required>
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
        <label >Daily Availability:</label>
        <select name="dailyAvailability[]" multiple required>
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          
        </select>

      </p>
      <p>
        Type:
        <select id="type" name="type">
            <option value='lab'>lab</option>
            <option value='teaching'>teaching</option>    
        </select>
      </p>
      <p><label>Computers</label><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="computers" name="computers" min="0", max="200" value="0"></p>
      <p><label>Projector</label><input class="w3-input w3-padding-16 w3-border" type="checkbox" placeholder="projector" name="projector"></p>
      <p><label>Locked</label><input class="w3-input w3-padding-16 w3-border" type="checkbox" placeholder="locked" name="locked"></p>
      
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

