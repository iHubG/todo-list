<?php 
    $servername = 'localhost';
    $username = 'ian';
    $password = 'Admin1234';
    $dbname = 'user_task';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn){
        echo "Connection Error" . mysqli_connect_error();
    }
?>