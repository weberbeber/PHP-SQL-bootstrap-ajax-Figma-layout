<?php

$link = mysqli_connect('localhost', 'root', '', 'shop');


// Check connection
if($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Print host information
echo "Connect Successfully. Host info: " . mysqli_get_host_info($link);

mysqli_close($link);