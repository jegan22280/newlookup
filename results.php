<?php  require_once 'includes/databaseConnection.php';  ?>
<?php  require_once 'includes/sessions.php';  ?>
<?php  require_once 'includes/header.php';  ?>
<?php  require_once 'includes/functions.php';  ?>
<?php
//submit button clicked
if (isset($_GET['SubmitButton'])) {
  //if the wildcard isnt presented...
  if ($_GET['scac'] != '0Z0Z') {
    //do all this noise
    //1. check to see if anything is filled out
    if (($_GET['scac'] == '') && ($_GET['pros'] == '')) {
      $_SESSION["errorMessage"] = 'No input.';
      redirect_to('error.php');
    }
    //if the scac is set, check it's format
    if  (isset($_GET['scac'])) {
      //check scac length and format
      if (strlen($_GET['scac']) == 4) {
        $scacRegex = '/^([a-zA-Z0-9\-]{4})/';

        $_SESSION['inputScac'] = $_GET['scac'];
        if (!preg_match($scacRegex,$_SESSION['inputScac'])) {
          $_SESSION["errorMessage"] = 'Incorrect or missing SCAC input.';
          redirect_to('error.php');
        }
      } else {
        $_SESSION["errorMessage"] = 'Incorrect or missing SCAC input.';
        redirect_to('error.php');
      }
    }
  } else {
    $_SESSION['inputScac'] = '0Z0Z';
  }
  //if scac and pros are set, check validity of pros
  if (isset($_GET['pros'])) {
    if (strlen($_GET['pros']) > 0) {
      $proRegex = '/^([a-zA-Z0-9\-\,\.\ \t]*$)/';
      $pros = $_GET['pros'];
      $_SESSION['pros'] = $pros;
      if (!preg_match($proRegex,$pros)) {
        $_SESSION["errorMessage"] = 'Incorrect or missing PRO input.';
        redirect_to('error.php');
      }
    } else {
      $_SESSION["errorMessage"] = 'incorrect or missing PRO input.';
      redirect_to('error.php');
    }
  }
}
?>
<!-- preloader -->
<div class="se-pre-con"></div>

<div class="container" role="main" style="margin-top:10rem">
  <nav class="navbar navbar-expand-md navbar-default fixed-top">
    <!-- adding the header form -->
    
    <div class="mx-auto mt-1" style="width:50%;">
      <?php require 'includes/headForm.php' ?>
    </div>
    

    
  </nav>
  
 <?php

$jsonArray = array();
$errorArray = array();
$errorArrayView = array();
$haystackArray = array();
$searchArray = array();
$possibles = '';
//make a variable to represent the scac
$inputScac = $_SESSION['inputScac'];
// make an array  based on the pros passed
$_SESSION['prosCommaList'] = str_replace(" ","','",$pros);
$prosArray = explode(" ",$pros);
$_SESSION['uniqueProsArray'] = array_unique($prosArray);
$inputScac = $_SESSION['inputScac'];
//start building a search statemeent
$searchStmtWhere = "";
//this part of the sql statement will never change the word WHERESTMT is a placeholder and will be replaced
$searchStmt = "SELECT 
    
case
when queue = 'Reject' then 'Rejected'
when extract_date <> '' or queue = 'Approve' then 'Processed'
when ready_to_extract <>'' then 'Approved / Pending Payment'
when ready_to_extract = '' and extract_date = '' then 'Pending Audit'
end as inv_status,

case
when queue = 'Reject' then 'Rejected'
when extract_date <> '' or queue = 'Approve' then 'Processed'
when ready_to_extract <>'' then 'Approved / Pending AP'
when ready_to_extract = '' and extract_date = '' then 'Pending Audit'
end as exportStatus,

invoices.owner,
invoices.oid,
invoices.scac,
trim(trailing ' (Load ID)' from invoices.primary_ref) as primary_ref,
invoices.invoice_number,
invoices.inv_charge,
format(invoices.inv_charge,2) as finv_charge,
trim(substring_index(invoices.ship_date,' ', 1)) as ship_date,
trim(substring_index(invoices.extract_date,' ', 1)) as extract_date,
trim(leading'0'from replace(replace(lower(concat(invoices.primary_ref,' ',pro,' ',pro_number,' ',po_number,' ',order_number,' ',invoice_number,' ')),'-',''),'.','')) as possibles,
concat(invoices.primary_ref,', ',pro,', ',pro_number,', ',po_number,', ',order_number,', ',invoice_number,' ') as search_keys

from invoices

where ([WHERESTMT])";
// if the scac is the wildcard scac, skip the  scac filter
if ($inputScac  != '0Z0Z') {
$searchStmt = $searchStmt." and scac = '".$inputScac."';";
} else {
  $searchStmt = $searchStmt."";
}




foreach ($_SESSION['uniqueProsArray'] as $key) {
  //this eliminates the whole searching for nothing gets me everything. this situation is caused by the allowance of bad data entry
  if ($key == '' || $key == ' ') {
    $key = '123456789_invalid_123456789';
  }

  if (strlen($key) >= 4) {
  $trimedKey = preg_replace('/^0+/', '', $key);
  $trimedKey = str_replace("'","",$trimedKey);
  $trimedKey = str_replace("-","",$trimedKey);
  $trimedKey = str_replace(".","",$trimedKey);
  $value = '%'.$trimedKey.'%';
  //this is the where clause of the serch statement. it will be repeated for each value in the array.
  $searchStmtWhere = $searchStmtWhere."(trim(leading'0'from replace(replace(lower(concat(invoices.primary_ref,' ',pro,' ',pro_number,' ',po_number,' ',order_number,' ',invoice_number,' ')),'-',''),'.','')) like lower('".$value."')) or ";
  }
}

//trimming the final or off the query
$searchStmtWhere = substr($searchStmtWhere,0,-3);
// adding the where statment(s)to the query
$searchStmt = str_replace("[WHERESTMT]", $searchStmtWhere,$searchStmt);

// executing
  $stmt = $conn->query($searchStmt);
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    //for each row retrned add the search string to the row the for each defines the var i search for


    $jsonArray[] = $row;
    $haystackArray[] = $row['possibles'];
  }
//haystach for error search
$haystack = implode(' ',array_unique($haystackArray));

$_SESSION['jsonResults'] = $jsonArray;

// search the haystack for errors;
foreach ($_SESSION['uniqueProsArray'] as $errorKey) {
  $trimedKey = preg_replace('/^0+/', '', $errorKey);
  $trimedKey = str_replace("'","",$trimedKey);
  $trimedKey = str_replace("-","",$trimedKey);
  $trimedKey = str_replace(".","",$trimedKey);
  $errorValue = strtolower($trimedKey);

  if (strpos($haystack,$errorValue) === false) {
    array_push($errorArray,$errorKey);
  }
}
?>
<!-- adding preloder -->

<div class="container">

<?php
if (count($errorArray) != 0) {
?>

  <div class="row mb-3">
    <div class="col-6 offset-3">
      <table class="table-small table-danger w-100">
        <thead>
          <th  class="px-2">The following items were not found in the database: <a href="https://dblinc.freshdesk.com/support/solutions/articles/47001121515-the-following-items-were-not-found-in-the-database"><i class="far fa-question-circle"></i></a></th>
        </thead>
        <tbody>

          <?php
            foreach ($errorArray as $displayKey) {
          ?>
          <tr>
           <td class="px-2"><?php echo $displayKey; ?></td>
          </tr>
          <?php
            }
           ?>

        </tbody>
      </table>
    </div>
  </div>
  <?php
  }
  ?>

  <div class="row">
    <div class="col-12">
      <!-- eexport button -->
      <div class="row">
        <div class="col-12">
          <button id="export" class="btn btn-info shadow"type="button" name="button"><i class="fas fa-file-export"></i> Export data to CSV</button>
        </div>
      </div>
      <div id="ttable" class="mt-5"></div>
      </div>
    <!-- <div class="row"> -->
      <div class="col-12 py-3">
        <!-- contact button -->
        <!-- <a class="btn btn-primary shadow ml-2 mt-1 float-right text-light" href="inquiry.php" role="button" ><i class="fas fa-envelope"></i> Contact us</a> -->
        <!-- export button -->
        <!-- <button id="export" class="btn btn-info shadow ml-2 mt-1 float-right"type="button" name="button"><i class="fas fa-file-export"></i> Export data to CSV</button> -->
      </div>
    <!-- </div> -->
  </div>
</div>

<script src="js/scripts.js"></script>
<?php require_once 'includes/footer.php';  ?>
