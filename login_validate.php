<?php
require './admin/connect.php';
//require 'admin/core.php';


if (isset($_POST['username'], $_POST['password'])){
    $name = $_POST['username'];
    $pass = $_POST['password'];
    $last_log_date = date('Y-m-d H:i:s');

    $qry="SELECT * FROM student WHERE username='$name' AND password='$pass' LIMIT 1";
    $qrycheck=$conn->query($qry);
    if ($qrycheck->num_rows > 0){
        while($fetch = $qrycheck->fetch_assoc()){
            $fullname=$fetch['fullname'];
            $username=$fetch['username'];
            $dept=$fetch['dept'];
            $id=$fetch['id'];
			
			
			session_start();
            $_SESSION['stdid']=$id;
            $_SESSION['user']=$username;
            $_SESSION['name']=$fullname;
            $_SESSION['dept']=$dept;

        }
        echo "True";
        // update last_log_date
        $update_last_log_date = "UPDATE student SET `last_log_date`='".$last_log_date."' WHERE `username`='".$username."'";
        $checkupdate = $conn->query($update_last_log_date);
    } else {
        echo "False";
    }
}
?>