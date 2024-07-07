<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include 'DBconnect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT CoachName, ContactPerson, CPContactNo FROM coach";
$result = $conn->query($query);

echo "<table>
         <thead>
             <tr>
                 <th>Coach Name</th>
                 <th>Emergency Contact</th>
                 <th>Emergency Contact No.</th>
                 <th></th>
             </tr>
         </thead>
         <tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
             <td>{$row['CoachName']}</td>
             <td>{$row['ContactPerson']}</td>
             <td>{$row['CPContactNo']}</td>
             <td><button class='removeButton' data-coach-name='{$row['CoachName']}'>Remove</button></td>
          </tr>";
}

echo "</tbody></table>";

