<?php
require 'includes/databaseConnection.php';
require 'includes/header.php';
require 'includes/functions.php';
require 'includes/sessions.php';


if (isset($_POST['testButton'])) {
  redirect_to("testresults.php");
}

 ?>

<div style="width:100%;" class="fixed-top">
  <a href="https://dblinc.freshdesk.com/support/home" class="float-right m-3"><i class="far fa-question-circle fa-3x"></i></a>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-1">
      <!-- form to collect info -->
      <form action="results.php" method="get" class="center-form" id="pro-form">
        <!-- heaader image -->
        <!-- TODO: ask jill for a high res version (png preffered) -->
        <a href="index.php">
          <img src="img/aborn-logo-long.jpg" alt="Aborn_and_company" class="ctr-img mb-4">
        </a>

        <div class="form-row">
          <!-- form input for SCAC -->
          <div class="form-group col-sm-2 ">
            <label for="SCACInput">SCAC
            <a href="scac.php?name=a" data-toggle='tooltip' data-placement='top' title='Click to find your SCAC'><i class="far fa-question-circle"></i></a></label>
            <div class="shadow">
              <input type="text" name="scac" class="form-control" id="SCACInput" value="<?php echo ( isset($_SESSION['inputScac'])) ? $_SESSION['inputScac'] : ""; ?>">
            </div>


          </div>

          <div class="form-group col-sm-10">
            <label for="PROInput">PRO Number(s)</label>
            <div class="input-group shadow">
              <input type="text" name="pros" class="form-control" id="PROInput" value="<?php echo (isset($_SESSION['pros'])) ? $_SESSION['pros'] : ""; ?>" class="">
              <div class="input-group-append">

                <button class="input-group-text" name="SubmitButton" type="submit" id='search'><a href="#"><i class="fas fa-arrow-right"></i></a></button>

              </div>
            </div>
          </div>
        </div> <!-- /.form-row -->
      </form><!-- /form -->
    </div><!-- /.col-md-10 -->

  </div><!-- /.row -->
  <div class="row mt-5">
    <div class="col-4 offset-4">
      <?php
      echo successMessage();
      ?>
    </div>

  </div>
</div><!-- /.container -->

<?php require 'includes/footer.php' ?>
