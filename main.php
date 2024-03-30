<?php
include 'connection.php';
session_start();
function username(){
    if (isset( $_SESSION['username'])){
        global $con;
        $username = $_SESSION['username'];
        $query = "SELECT * from users where username = '$username'";
        $result = mysqli_query($con,$query);
        if ($result){
            while ($row =mysqli_fetch_assoc($result))
            {
                $ext = $row['name'];
                echo $ext;
            }
        }
        else{
            echo "fail";
        }
    }
}
function products (){
    global $con;
    $query = "select * from products";
    $result = mysqli_query($con,$query);
    if ($result)
    {
        $text = [];
        while ($row = mysqli_fetch_assoc($result) )
        {
            $text[] = $row; 
        }  
        $jsonstring =  json_encode($text);
        file_put_contents('products.json',$jsonstring);
    }
    else{
        echo 'fail';
    }
}


function cart($pid)
{
    global $con;
    $username = $_SESSION['username'];
    $query = "SELECT * FROM cart WHERE username='$username' AND pid='$pid'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {

    } else {
        $query = "INSERT INTO cart (username, pid) VALUES ('$username', '$pid')";
        $result = mysqli_query($con, $query);
    }
}

function itemsincart()
{
    global $con;
    $username = $_SESSION['username'];
    $query = "SELECT * FROM cart c,products p WHERE username='$username' and c.pid = p.pid";
    $result = mysqli_query($con,$query);
    if ($result)
    {
        $products=[];
        while ($row =mysqli_fetch_assoc($result))
        {
            $products []= $row;
        }
        echo json_encode($products);
        //file_put_contents('products.json',$jsonstring);
    }
}


function itemremove($pid)
{
    global $con;
    $username = $_SESSION['username'];
    $query = "DELETE FROM cart where username ='$username' and pid = '$pid'";
    $result = mysqli_query($con,$query);
    if ($result){
        echo "success";
    }
    else{
        echo "false";
    }
}

function buy($pid)
{
    global $con;
    $username = $_SESSION['username'];
    $query  = "insert into orders (pid,username) values ('$pid','$username')";
    $result = mysqli_query($con,$query);
}
function orders()
{
    global $con;
    $username  = $_SESSION['username'];
    $query = "select * from orders o,products p where o.pid = p.pid and o.username = '$username'";
    $result = mysqli_query($con,$query);
    if ($result)
    {
        $items = [];
        while ($row= mysqli_fetch_assoc($result))
        {
            $items[] = $row;
        }
        echo json_encode($items);
    }

}
if(isset($_GET['f'])) {
    $functionName = $_GET['f'];
    if(function_exists($functionName)) {
        if ($functionName== 'cart' || $functionName =='itemremove' || $functionName == 'buy' ){
            $par = $_GET['p'];
            $functionName($par);
        }
        else{
        echo $functionName(); 
        }
    } else {
        echo "Function not found";
    }
} else {
    echo "No function specified";
}
exit();
?>