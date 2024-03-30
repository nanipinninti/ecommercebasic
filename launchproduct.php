<?php
include 'connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST')
{

    if (isset($_POST['productname']) && isset($_POST['description']) && isset($_POST['price']) && isset($_FILES['productimage'])) {
        $productname = $_POST['productname'];
        $description = $_POST['description'];
        $price = (int)$_POST['price'];
        $puserid = $_SESSION['sellername'];
        global $con;
        $temporarylocation = $_FILES["productimage"]["tmp_name"];
        $check = getimagesize($_FILES["productimage"]["tmp_name"]);
        if ($check)
        {
            $allowed = array('jpg','jpeg','png','gif','webp');
            $target_file = basename($_FILES["productimage"]["name"]);
            $extension = pathinfo($target_file,PATHINFO_EXTENSION);
            if (in_array($extension,$allowed))
            {
                $query = "insert into products (puserid,pname,description,price) values ('$puserid','$productname','$description','$price')";
                if(mysqli_query($con, $query)) {
                    // Get the UID of the inserted row
                    $uid = mysqli_insert_id($con);
                    $target_file = 'images/'.(string)$uid;
                    if (move_uploaded_file($temporarylocation,$target_file))
                    {
                        $query = "update products set image = '$uid' where pid = '$uid'";
                        if (mysqli_query($con,$query))
                        {
                            echo "sucess";
                            $_SESSION['REQUEST_METHOD'] ='NONE';
                        }
                    }
                    else {
                        echo 'img not uploaded';
                    }
                } 
                
            }
            else{
                echo 'please enter valid image';
            }
        }
        else{
            echo 'please enter valid image';
        }
    }
    else{
        echo "fuck";
    }

}
