<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include 'DBconnect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

//Coach
$lname = $_POST['c_lname'];
$fname = $_POST['c_fname'];
$mname = $_POST['c_mname'];

$Cfull_name = $fname . ' ' . $mname . ' ' . $lname;

$CN_name = $_POST['c_Nname'];
$CBday = $_POST['C_Bday'];
$homeadd = $_POST['homeadd'];
$C_FB = $_POST['FbLink'];
$C_contact = $_POST['c_contact'];
$Weight = $_POST['weight'];
$Height = $_POST['height'];
$status = $_POST['status'];

//Spouse
$Slname = $_POST['s_lname'];
$Sfname = $_POST['s_fname'];
$Smname = $_POST['s_mname'];

$Sfull_name = $Sfname . ' ' . $Smname . ' ' . $Slname;

$S_contact = $_POST['s_contact'];

$elname = $_POST['e_lname'];
$efname = $_POST['e_fname'];
$emname = $_POST['e_mname'];
$E_contact = $_POST['E_contact'];

$Efull_name = $efname . ' ' . $emname . ' ' . $elname;

$relation = $_POST['relation'];
$otherInput = isset($_POST['otherInput']) ? $_POST['otherInput'] : '';

if ($relation == 'Other') {
    $relation = $otherInput;
}

if($status == 'Married'){
    $stmt = $conn->prepare("INSERT INTO coach (
    CoachName, Nickname, Birthdate, Address, FbLink, ContactNo, Weight, Height,
    Status, Spouse, SContactNo, ContactPerson, CPContactNo, Relationship
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssss", $Cfull_name, $CN_name, $CBday, $homeadd, $C_FB, $C_contact, $Weight, $Height,
        $status, $Sfull_name, $S_contact, $Efull_name, $E_contact, $relation);
    
    if ($stmt->execute()) {
        echo "New record created successfully for coach table";
    } else {
        echo "Error: " . $stmt->error;
        echo "MySQL Error: " . mysqli_error($conn);
    }  
}else if($status == 'Single'){
    $stmt = $conn->prepare("INSERT INTO coach (
    CoachName, Nickname, Birthdate, Address, FbLink, ContactNo, Weight, Height,
    Status, ContactPerson, CPContactNo, Relationship
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssss", $Cfull_name, $CN_name, $CBday, $homeadd, $C_FB, $C_contact, $Weight, $Height,
        $status, $Efull_name, $E_contact, $relation);
    
    if ($stmt->execute()) {
        echo "New record created successfully for coach table";
    } else {
        echo "Error: " . $stmt->error;
        echo "MySQL Error: " . mysqli_error($conn);
    }  
}

$stmt->close();

$conn->close();