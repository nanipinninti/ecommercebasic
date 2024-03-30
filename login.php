<?php
include 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Using prepared statement to prevent SQL injection
        $query = "SELECT username FROM users WHERE username = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        // Check if username exists
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $query = "SELECT username FROM users WHERE username = ? and pass = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'ss', $username,$password);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt)>0)
            {
                $_SESSION['username'] = $username;
                echo 'successs';
                header('Location:main.html');
            }
            else{
                echo "incorrect password";
                echo "<a href='login.html' > back</a>";
            }

        } else {
            echo "Username does not exist";
            echo "<a href='login.html' > back</a>";
        }
    }
}

exit();
?>