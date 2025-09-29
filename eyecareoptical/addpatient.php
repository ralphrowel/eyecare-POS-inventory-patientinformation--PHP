<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "justine";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get patient data
$firstname = $_POST['FIRSTNAME'];
$middlename = $_POST['MIDDLENAME'];
$surname = $_POST['SURNAME'];
$birthdate = $_POST['BIRTHDATE'];
$gender = $_POST['GENDER'];
$phone = $_POST['PHONE_NUM'];
$email = $_POST['EMAIL'];
$address = $_POST['ADDRESS'];

// Get prescription data
$sphere = $_POST['SPHERE'] ?? '';
$cylinder = $_POST['CYLINDER'] ?? '';
$axis = $_POST['AXIS'] ?? '';
$lens = $_POST['LENS'] ?? '';
$pd = $_POST['PD'] ?? '';
$frame = $_POST['FRAME'] ?? '';
$tint = $_POST['TINT'] ?? '';
$addi = $_POST['ADDI'] ?? '';
$prescribed = $_POST['PRESCRIBED'] ?? '';

// Insert into p-info table
$sql1 = "INSERT INTO `p-info` (FIRSTNAME, MIDDLENAME, SURNAME, BIRTHDATE, GENDER, PHONE_NUM, EMAIL, ADDRESS) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("ssssssss", $firstname, $middlename, $surname, $birthdate, $gender, $phone, $email, $address);

// Insert into e-prescription table
$sql2 = "INSERT INTO `e-prescription` (SPHERE, CYLINDER, AXIS, LENS, PD, FRAME, TINT, ADDI, PRESCRIBED) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("sssssssss", $sphere, $cylinder, $axis, $lens, $pd, $frame, $tint, $addi, $prescribed);

// Execute both queries
if ($stmt1->execute() && $stmt2->execute()) {
    echo "Patient and prescription added successfully!";
} else {
    echo "Error: " . $stmt1->error . "<br>" . $stmt2->error;
}

$stmt1->close();
$stmt2->close();
$conn->close();
?>
