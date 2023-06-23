<?php
require 'includes/databaseConnection.php';
require 'includes/header.php';
require 'includes/functions.php';
require_once 'includes/errorsDatabaseConnection.php';
require_once 'includes/sessions.php';
require_once 'includes/functions.php';
?>

<?php 
$errorSCAC =  $_GET["scac"];
$errorPro =  $_GET["pro"];
echo $errorSCAC;
echo "<br>";
echo $errorPro;
echo "<br>";
$eConn = e_conn();

$errorIDSelectStmt = $eConn->prepare("SELECT id from errors where E_SCAC = ? and E_PRO = ?");
$errorIDSelectStmt->bind_param("ss",$errorSCAC,$errorPro);
$errorIDSelectStmt->execute();
$result = $errorIDSelectStmt->get_result();
$resultArray = $result -> fetch_array(MYSQLI_ASSOC);
$errorID = $resultArray['id'];
var_dump($errorID);
echo "<BR><BR>";
var_dump($resultArray);

if ($errorID == "") {
    # display error
    $_SESSION["errorMessage"] = "No error found.";
    echo errorMessage();
} else {
    redirect_to("https://payments.dblinc.net/php/tmserrors/error_entry.php?id=".$errorID);
}
?>


<?php require_once 'includes/footer.php';  ?>