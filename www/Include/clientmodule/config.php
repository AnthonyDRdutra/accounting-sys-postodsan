<?php
$con = mysqli_connect('localhost', 'root', '1234', 'dbpostodsan');
if($con){
    die("Connection Failed" . mysqli_connect_error());
}