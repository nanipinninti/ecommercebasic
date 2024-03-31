<?php
session_start();
include 'connection.php';
$sellername = $_SESSION['sellername'];
function items()
{
    global $con;
    global $sellername;
    $query = "select p.*,count(p.pid) as c from  users u,orders o,seller s,products p where u.username = o.username and 
        o.pid = p.pid and p.puserid=s.sellerid and s.sellerid='$sellername' group by o.pid;";
    $result = mysqli_query($con,$query);
    if ($result)
    {
        if (mysqli_num_rows($result)>0){
            $text = [];
            while ($row = mysqli_fetch_assoc($result))
            {
                $text[] = $row;
            }
            $json_string = json_encode($text);
            echo $json_string;
        }
        else{
            echo json_encode("");
        }
    }
    
}
function sellername()
{
    global $sellername;
    echo $sellername;
}
function sellerlogout()
{
    global $sellername;
    session_destroy();
}
function customerdetails($pid)
{
    global $con;
    global $sellername;
    $query = "select u.username,u.name,u.address ,o.status,o.orderid from orders o,users u where
    u.username = o.username and pid = '$pid'";
    $result = mysqli_query($con,$query);
    if($result)
    {
        $text = [];
        while ($row = mysqli_fetch_assoc($result))
        {
            $text[] = $row;
        }
        $json_string = json_encode($text);
        echo $json_string;
    }
    else {
        echo "query not executed";
    }
}
if (isset($_GET['f']))
{
    $functionName = $_GET['f'];
    if ($functionName=='customerdetails')
    {
        $functionName($_GET['pid']);
    }
    else{
        $functionName();
    }
}
?>