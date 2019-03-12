# algoritma-stemming-nazief-adriani


<?php
function connect($database, $host, $user, $pass = ''){
    $conn=mysqli_connect($host,$user,$pass);
    mysqli_select_db($conn, $database);
    return $conn;
}
function query($sql, $conn){
    return mysqli_query($conn, $sql) or die(mysql_error());  
}
?>