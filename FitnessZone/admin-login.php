<?php 

session_start(); 

include "db_conn.php";

if (isset($_POST['Username']) && isset($_POST['Name']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['Username']);
    $name = validate($_POST['Name']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        $_SESSION['login_error'] = true;
        header("Location: index.php?error=User Name is required");
        exit();
    }else if(empty($name)){
        $_SESSION['login_error'] = true;
        header("Location: index.php?error=Name is required");
        exit();
    }else if(empty($pass)){
        $_SESSION['login_error'] = true;
        header("Location: index.php?error=Password is required");
        exit();
        
    }else{
        $sql = "SELECT * FROM admins WHERE Username='$uname' AND Name='$name' AND password='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['Username'] === $uname && $row['Name'] === $name && $row['password'] === $pass) {
                echo "Logged in!";
                $_SESSION['Username'] = $row['Username'];
                $_SESSION['Name'] = $row['Name'];
                $_SESSION['id'] = $row['id'];
                header("Location: dashboard.html");
                exit();
            }else{
                $_SESSION['login_error'] = true;
                header("Location: index.php?error=Incorect User name or password");
                exit();
            }
        }else{
            $_SESSION['login_error'] = true;
            header("Location: index.php?error=Incorect User name or password");
            exit();
        }
    }
}else{
    header("Location: index.php");
    exit();
}