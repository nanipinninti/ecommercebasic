<?php
include 'connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['sellername']) && isset($_POST['password'])) 
    {
        global $con;
        $sellername = $_POST['sellername'];
        $password = $_POST['password'];

        $query = "select * from seller where sellerid = '$sellername'";
        $result  = mysqli_query($con,$query);
        if (mysqli_num_rows($result)>0)
        {
            $query = "select * from seller where sellerid = '$sellername' and pass = '$password'";
            $result = mysqli_query($con,$query);
            if (mysqli_num_rows($result)>0)
            {
                $_SESSION['sellername'] = $sellername;
                header('Location:seller.html');
                exit();
            }
            else{
                echo 'incorrect password';
                echo "Go back <a href='sellerlogin.html'>login page</a>";
            }
        }
        else{
            echo 'seller id doesnt exist, you should be signup first!';
            echo "Go back <a href='sellerlogin.html'>login page</a>";
        }
    }
}

?>