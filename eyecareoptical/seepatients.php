<?php
$conn = new mysqli("localhost", "root", "", "justine");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "
SELECT 
  p.Patient_ID, p.FIRSTNAME, p.SURNAME, p.BIRTHDATE, p.GENDER, p.ADDRESS,
  e.Eye_ID, e.SPHERE, e.CYLINDER, e.AXIS, e.LENS, e.PD, e.FRAME, e.TINT, e.ADDI, e.PRESCRIBED
FROM `p-info` p
LEFT JOIN `e-prescription` e ON p.Patient_ID = e.Patient_ID
";

$result = $conn->query($sql);
?>

