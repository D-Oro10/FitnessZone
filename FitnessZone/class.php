<?php

$host = "localhost: 3306"; 
$username = "root"; 
$password = ""; 
$dbname = "dba_gym"; 

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add a new class
if (isset($_POST['add_class'])) {
    $ClassId = $_POST['ClassId'];
    $ClassName = $_POST['ClassName'];
    $Duration = $_POST['Duration'];
    $ClassDay = implode(", ", $_POST['ClassDay']);

// Insert the new class into the database
$sql = "INSERT INTO classes (ClassId, ClassName, Duration, ClassDay)
        VALUES ('$ClassId', '$ClassName', '$Duration', '$ClassDay')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Class added successfully.'); 
    window.location.href = 'class.php';</script>";

} else {
    echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); 
    window.location.href = 'class.php';</script>";
    }
}

// Delete a class
if (isset($_GET['delete_class'])) {
    $ClassId = $_GET['delete_class'];

    // Delete the class from the database
    $sql = "DELETE FROM classes WHERE ClassId='$ClassId'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Class deleted successfully.');
        window.location.href = 'class.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');
        window.location.href = 'class.php';</script>";
    }
}

// Fetch all classes from the database
$sql = "SELECT * FROM classes";
$result = mysqli_query($conn, $sql);

?> 

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Class Scheduler</title>
    <link rel="stylesheet" type="text/css" href="class.css">
</head>
<body>
    <h1>Class Scheduler</h1>

    <div class="container">

        <div id="addClassModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                
                <form method="POST" action="">
                <h2>Add Class:</h2>
                    <label for="ClassId">Class ID:</label>
                    <input type="text" name="ClassId" required><br><br>
                    <label for="ClassName">Class Name:</label>
                    <input type="text" name="ClassName" required><br><br>
                    <label for="Duration">Duration:</label>
                    <input type="text" name="Duration" required><br><br>
                    <label for="ClassDay">Day/s of Classes:</label><br>
                    <input type="checkbox" name="ClassDay[]" value="Monday"> Monday
                    <input type="checkbox" name="ClassDay[]" value="Tuesday"> Tuesday
                    <input type="checkbox" name="ClassDay[]" value="Wednesday"> Wednesday
                    <input type="checkbox" name="ClassDay[]" value="Thursday"> Thursday
                    <input type="checkbox" name="ClassDay[]" value="Friday"> Friday
                    <input type="checkbox" name="ClassDay[]" value="Saturday"> Saturday
                    <input type="checkbox" name="ClassDay[]" value="Sunday"> Sunday
                    <br><br>
                    <input type="submit" name="add_class" value="Add Class">
                </form>
            </div>
        </div>

        <h2>All Classes</h2>
        <table>
            <tr>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Duration(hrs)</th>
                <th>Class Day</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ClassID'] . "</td>";
                echo "<td>" . $row['ClassName'] . "</td>";
                echo "<td>" . $row['Duration'] . "</td>";
                echo "<td>" . $row['ClassDay'] . "</td>";
                echo "<td><a href='?delete_class=" . $row['ClassID'] . "'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
         <button id="addClassBtn">Add A New Class</button>
    </div>

    <script>
        var modal = document.getElementById('addClassModal');
        var btn = document.getElementById('addClassBtn');
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
    </script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>