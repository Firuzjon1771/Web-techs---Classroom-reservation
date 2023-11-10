<?php
/* Opens connection with db. Called every time a sql statement is occuring.*/
function openConnection(){
	// Database server name
	$servername = "localhost"; 
	// database username (root in xampp)
	$username = "root"; 
	// database password ("" in xampp)
	$password = ""; 
	// database name
	$dbname = "db";

	// Create a connection
	$connection = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($connection->connect_error) {
	    die("Connection failed: " . $connection->connect_error);
	}
	return $connection;
}
/* Closes connection. Called after sql stqtement.*/
function closeConnection($connection){
	$connection->close();
}
/* Checks if email exists in db.*/
function checkEmail($email){
	$connection = openConnection();
	$sql = "SELECT * FROM user WHERE email='$email'";
	$result = $connection->query($sql);
	$exists = false;
	if ($result->num_rows > 0) {
		$exists = true;
	}

	closeConnection($connection);
	return $exists;
}
/* Checks if password of user with email is ok.*/
function checkPassword($email,$password){
	$connection = openConnection();
	$sql = "SELECT * FROM user WHERE email='$email' and password='$password'";
	$result = $connection->query($sql);
	$exists = false;
	if ($result->num_rows > 0) {
		$exists = true;
	}

	closeConnection($connection);
	return $exists;
}
/* Checks if user with email is approved.*/
function checkApproved($email){
	$connection = openConnection();
	$sql = "SELECT * FROM user WHERE email='$email' and approved='1'";
	$result = $connection->query($sql);
	$approved = false;
	if ($result->num_rows > 0) {
		$approved = true;
	}

	closeConnection($connection);
	return $approved;
}
/* Returns user information.*/
function getUser($email){
	$connection = openConnection();
	$sql = "SELECT * FROM user WHERE email='$email'";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 if ($row = $result->fetch_assoc()) {
		 	$user = [
        		'email' => $row['email'],
		        'fullname' => $row['fullname'],
        		'role' => $row['role'],
        		'department' => $row['department'],
        		'type' => $row['type']
    		];
		 }
	}
	closeConnection($connection);
	return $user;
}
/* Returns users of a department information.*/
function getUsers($department){
	$connection = openConnection();
	$users = array();
	$sql = "SELECT * FROM user WHERE department='$department'";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 while ($row = $result->fetch_assoc()) {
		 	$users[$row['email']] = [
		        'fullname' => $row['fullname'],
        		'role' => $row['role'],
        		'department' => $row['department'],
        		'type' => $row['type'],
        		'approved' => $row['approved']
    		];
		 }
	}
	closeConnection($connection);
	return $users;
}
/* Returns all classrooms.*/
function getClassrooms(){
	$connection = openConnection();
	$classrooms = array();
	$sql = "SELECT * FROM classroom";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 while ($row = $result->fetch_assoc()) {
		 	$classrooms[$row['id']] = [
		        'building' => $row['building'],
        		'address' => $row['address'],
        		'capacity' => $row['capacity']
    		];
		 }
	}
	closeConnection($connection);
	return $classrooms;
}
/* Returns teachers of a department.*/
function getTeachers($department){
	$connection = openConnection();
	$teachers = array();
	$sql = "SELECT * FROM user WHERE department='$department' and FIND_IN_SET('teacher', role) > 0";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 while ($row = $result->fetch_assoc()) {
		 	$teachers[$row['email']] = [
		        'fullname' => $row['fullname'],
        		'role' => $row['role'],
        		'department' => $row['department'],
        		'type' => $row['type'],
        		'approved' => $row['approved']
    		];
		 }
	}
	closeConnection($connection);
	return $teachers;
}
/* Returns all teachings.*/
function getTeachings($department){
	$connection = openConnection();
	$teachings = array();
	$sql = "SELECT * FROM teaching where department='$department'";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 while ($row = $result->fetch_assoc()) {
		 	$user = getUser($row['teacher']);
		 	$teachings[$row['id']] = [
		        'courseCode' => $row['courseCode'],
        		'course' => $row['course'],
        		'teacher' => $row['teacher'],
        		'teachername' => $user['fullname'],
        		'type' => $row['type']
    		];
		 }
	}
	closeConnection($connection);
	return $teachings;
}
/* Returns all reservations.*/
function getReservations(){
	$connection = openConnection();
	$reservations = array();
	$sql = "SELECT * FROM reservation";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 while ($row = $result->fetch_assoc()) {
		 	$user = getUser($row['teacher']);
		 	$teaching = getTeaching($row['teaching']);
		 	$reservations[$row['id']] = [
		        'teaching' => $row['teaching'],
		        'course' => $teaching['course'],
        		'teacher' => $row['teacher'],
        		'teachername' => $user['fullname'],
        		'day' => $row['day'],
        		'hour' => $row['hour'],
        		'duration' => $row['duration']
    		];
		 }
	}
	closeConnection($connection);
	return $reservations;
}
/* Returns classrooms with search term.*/
function getClassroomsTerm($term){
	$connection = openConnection();
	$classrooms = array();
	$sql = "SELECT * FROM classroom WHERE building LIKE '%$term%' OR address LIKE '%term%';";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 while ($row = $result->fetch_assoc()) {
		 	$classrooms[$row['id']] = [
		        'building' => $row['building'],
        		'address' => $row['address'],
        		'capacity' => $row['capacity']
    		];
		 }
	}
	closeConnection($connection);
	return $classrooms;
}
/* Return classroom with given id. */
function getClassroom($id){
	$connection = openConnection();
	$sql = "SELECT * FROM classroom WHERE id='$id'";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 if ($row = $result->fetch_assoc()) {
		 	$classroom = [
        		'id' => $row['id'],
		        'building' => $row['building'],
        		'address' => $row['address'],
        		'capacity' => $row['capacity'],
        		'hourlyAvailability' => $row['hourlyAvailability'],
        		'dailyAvailability' => $row['dailyAvailability'],
        		'type' => $row['type'],
        		'computers' => $row['computers'],
        		'projector' => $row['projector'],
        		'locked' => $row['locked']
    		];
		 }
	}
	else{
		$classroom = false;
	}

	closeConnection($connection);
	return $classroom;
}
/* Return teaching with given id. */
function getTeaching($id){
	$connection = openConnection();
	$sql = "SELECT * FROM teaching WHERE id ='$id'";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 if ($row = $result->fetch_assoc()) {
		 	$user = getUser($row['teacher']);
		 	$teaching= [
		 		'id' => $row['id'],
		        'courseCode' => $row['courseCode'],
        		'course' => $row['course'],
        		'teacher' => $row['teacher'],
        		'teachername' => $user['fullname'],
        		'type' => $row['type'],
        		'semester' => $row['semester'],
        		'department' => $row['department'],
        		'hours' => $row['hours']
    		];
		 }
	}
	else{
		$teaching = false;
	}

	closeConnection($connection);
	return $teaching;
}
/* Return reservation with given id. */
function getReservation($id){
	$connection = openConnection();
	$sql = "SELECT * FROM reservation WHERE id ='$id'";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 if ($row = $result->fetch_assoc()) {
		 	$user = getUser($row['teacher']);
		 	$teaching = getTeaching($row['teaching']);
		 	$reservation= [
		 		'id' => $row['id'],
		 		'teaching' => $row['teaching'],
		        'courseCode' => $teaching['courseCode'],
        		'course' => $teaching['course'],
        		'classroom' => $row['classroom'],
        		'teacher' => $row['teacher'],
        		'teachername' => $user['fullname'],
        		'day' => $row['day'],
        		'hour' => $row['hour'],
        		'duration' => $row['duration']
    		];
		 }
	}
	else{
		$reservation = false;
	}

	closeConnection($connection);
	return $reservation;
}
function updateClassroom($id,$building,$address,$capacity,$hourlyAvailability,$dailyAvailability,$type,$computers,$projector,$locked){
	$connection = openConnection();
	 $sql = "UPDATE classroom SET building = '$building', address = '$address',
            capacity = $capacity,hourlyAvailability = '$hourlyAvailability',
            dailyAvailability = '$dailyAvailability',type = '$type',
            computers = '$computers', projector = '$projector',locked = '$locked'
            WHERE id = $id";
    $connection->query($sql);
	closeConnection($connection);
}
/* insert classroom. */
function insertClassroom($building,$address,$capacity,$hourlyAvailability,$dailyAvailability,$type,$computers,$projector,$locked){
	$connection = openConnection();
	$sql = "INSERT INTO `classroom` (`building`, `address`, `capacity`, `hourlyAvailability`, `dailyAvailability`, `type`,`computers`,`projector`,`locked`) 
        VALUES ('$building', '$address', '$capacity', '$hourlyAvailability', '$dailyAvailability', '$type','$computers','$projector','$locked')";
    $connection->query($sql);
    echo $connection->error;
    closeConnection($connection);
}
/* Is classroom available. */
function availableClassroom($id,$day,$hour){  
	$connection = openConnection();
	$available = false;
	$sql = "SELECT * FROM classroom WHERE id='$id' and FIND_IN_SET('$day', dailyAvailability) > 0 and FIND_IN_SET('$hour', hourlyAvailability) > 0";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		$available = true;
	}
	closeConnection($connection);
	return $available;
}
/* Is classroom booked. */
function bookedClassroom($id,$day,$hour){
	$connection = openConnection();
	$booked = false;
	$sql = "SELECT * FROM reservation WHERE classroom='$id' and day = '$day' and FIND_IN_SET('$hour', hour) > 0";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		if ($row = $result->fetch_assoc()) {
			$teaching = getTeaching($row['teaching']);
			$booked = $teaching['courseCode'];
		}
	}
	closeConnection($connection);
	return $booked;
}
/* update teaching.*/
function updateTeaching($id,$courseCode,$course,$teacher,$type,$department,$semester,$hours){
	$connection = openConnection();
	 $sql = "UPDATE teaching SET courseCode = '$courseCode', course = '$course',
            teacher = '$teacher', type = '$type',
            semester = '$semester', department = '$department',hours = '$hours'
            WHERE id = $id";
    $connection->query($sql);
	closeConnection($connection);
}
/* insert teaching. */
function insertTeaching($courseCode,$course,$teacher,$type,$department,$semester,$hours){
	$connection = openConnection();
	$sql = "INSERT INTO `teaching` (`courseCode`, `course`, `teacher`, `type`, `department`, `semester`, `hours`) 
        VALUES ('$courseCode', '$course', '$teacher', '$type', '$department','$semester','$hours')";
    $connection->query($sql);
    echo $connection->error;
    closeConnection($connection);
}
/* Returns an array of the form [10:00,11:00,12:00] if for example parameters
are 10:00, 3. If after 21:00 returns false. */
function getHours($hour,$duration){
	$hours = ['09:00', '10:00', '11:00', '12:00', '13:00','14:00', '15:00', 
	'16:00', '17:00', '18:00','19:00', '20:00', '21:00'];
	$index = array_search($hour, $hours);
	$length = count($hours);
	if ($index+$duration>$length){
		return false;
	}
	$conhours = array_slice($hours, $index, $duration);
	return $conhours;
	
}
/* insert reservation. */
function insertReservation($teaching,$teacher,$classroom,$day,$hour,$duration){
	$connection = openConnection();
	$hours = getHours($hour,$duration);
	if ($hours == false){
		return false;
	}
	
	foreach ($hours as $hour) {
		if (!(availableClassroom($classroom,$day,$hour)&& !bookedClassroom($classroom,$day,$hour))){
			return false;
			

		}
	}
	$hours = implode(',', $hours);
	$sql = "INSERT INTO `reservation` (`teaching`, `teacher`,`classroom`, `day`, `hour`, `duration`) 
        VALUES ('$teaching', '$teacher','$classroom', '$day', '$hours', '$duration')";
    $connection->query($sql);
    
    closeConnection($connection);
    return true;
}
/* Update reservation. */
function updateReservation($id,$classroom,$day,$hour,$duration){
	$connection = openConnection();
	$hours = getHours($hour,$duration);
	if ($hours == false){
		return false;
	}
	foreach ($hours as $hour) {
		if (!(availableClassroom($classroom,$day,$hour)&& !bookedClassroom($classroom,$day,$hour))){
			return false;
			

		}
	}
	$hours = implode(',', $hours);
	$sql = "UPDATE reservation SET classroom = '$classroom', day = '$day', hour = '$hours', duration='$duration' WHERE id = '$id';";
    $connection->query($sql);
    closeConnection($connection);
    return true;
}
/* Updates user profile. */
function updateProfile($email,$fullname,$type){
	$connection = openConnection();
    $sql = "UPDATE user SET fullname = '$fullname', type = '$type' WHERE email = '$email';";
    $connection->query($sql);
    closeConnection($connection);
}
/* Approves user with email.*/
function approveUser($email){
    $connection = openConnection();
    $sql = "UPDATE user SET approved = '1' WHERE email = '$email';";
    $connection->query($sql);
    closeConnection($connection);
}
/* Delete user with email.*/
function deleteUser($email){
    $connection = openConnection();
    $sql = "DELETE FROM user WHERE email = '$email';";
    $connection->query($sql);
    closeConnection($connection);
}
/* Delete classroom with id.*/
function deleteClassroom($id){
    $connection = openConnection();
    $sql = "DELETE FROM classroom WHERE id = '$id';";
    $connection->query($sql);
    closeConnection($connection);
}
/* Delete teaching with id.*/
function deleteTeaching($id){
    $connection = openConnection();
    $sql = "DELETE FROM teaching WHERE id = '$id';";
    $connection->query($sql);
    closeConnection($connection);
}
/* Delete reservation with id.*/
function deleteReservation($id){
    $connection = openConnection();
    $sql = "DELETE FROM reservation WHERE id = '$id';";
    $connection->query($sql);
    closeConnection($connection);
}
/* Returns departments. */
function getDepartments(){
	$connection = openConnection();
	$departments = array();
	$sql = "SELECT * FROM department";
	$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		 while ($row = $result->fetch_assoc()) {
		 	$departments[$row['id']] = $row['name'];
		 }
	}
	closeConnection($connection);
	return $departments;
}
/* Inserts a new User, not approved yet. */
function insertUser($email, $password, $fullname, $roles, $department, $type){
	$connection = openConnection();
	$sql = "INSERT INTO `user` (`email`, `password`, `fullname`, `role`, `department`, `type`) 
        VALUES ('$email', '$password', '$fullname', '$roles', '$department', '$type')";
    $connection->query($sql);
    closeConnection($connection);

}






?>