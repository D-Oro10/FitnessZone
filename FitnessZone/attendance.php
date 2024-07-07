<?php

$host = "localhost: 3306";
$username = "root";
$password = "";
$dbname = "dba_gym";

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM attendance";
$result = mysqli_query($conn, $sql);

?> 

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Record</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Attendance Page</title>
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Catamaran:wght@600;700;800;900&family=Rubik:wght@400;500;800&display=swap"
      rel="stylesheet"
    />
</head>
<section
    id="home"
    aria-label="hero"
    data-section
    style="background-image: url('images/hero-bg.png')"
>

<body>
    <h1>Attendance Record</h1>
    <div>
        <label for="search">Search:</label>
        <input type="text" id="search" onkeyup="filterTable()" placeholder="Search member ID">
    </div>
    <form method="post" action="update_attendance.php">
        <table>
            <tr>
                <th>Appointment ID</th>
                <th>Attendance Code</th>
                <th>Member ID</th>
                <th>Schedule</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['AppointmentID'] . "</td>";
                echo "<td>";
                echo "<input type='hidden' name='appointment_id[]' value='" . $row['AppointmentID'] . "'>";
                echo "<select name='attendance_code[]'>";
                echo "<option value='Y'" . ($row['AttendanceCode'] == 'Y' ? ' selected' : '') . ">Yes</option>";
                echo "<option value='N'" . ($row['AttendanceCode'] == 'N' ? ' selected' : '') . ">No</option>";
                echo "</select>";
                echo "</td>";
                echo "<td>" . $row['MemberID'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td><a href='update_attendance.php?delete_attendance=" . $row['AppointmentID'] . "'>Delete</a></td>";
                echo "</tr>";
            }
            ?>

        </table>
        <div class="update" style="text-align: center;">
          <button type="submit">Update Attendance</button>
        </div>
    </form>
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // Adjust the index based on the column you want to search

                if (td) {
                    txtValue = td.textContent || td.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>

