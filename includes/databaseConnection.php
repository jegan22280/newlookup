<?php
//function dbconn(){
  // Static variables are remembered between function calls. Otherwise, each call to the function would make a new connection.
  //static $myConn = null;
  // Checks if there is a value assigned from a previous call.
  //if ($myConn === null)
  //{
      //turn on error reporting
      //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      // If no connection was made before, it is made now and assigned to the static variable $myConn.
      //$myConn = new mysqli('192.168.0.16', 'jegan', 'JusEga@1359', 'aborn_inquire');
  //}
  // The connection is returned, whether it was made now or during a previous call.
  //return $myConn;
//}

?>


<?php
$servername = "192.168.0.16";
$username = "jegan";
$password = "JusEga@1359";

try {
    $conn = new PDO("mysql:host=$servername;dbname=aborn_inquire", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
