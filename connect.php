<?
$conn = mysqli_connect("xxxxxxxxx", "xxxxxxxxx", "xxxxxxxxxxx", "xxxxxxxxxxxx");
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
mysqli_set_charset($conn , 'utf8' );

?>