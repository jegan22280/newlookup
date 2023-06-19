<form action="results.php" method="get" id="pro-form">
  <!-- heaader image -->
  <!-- TODO: ask jill for a high res version (png preffered) -->

  <div class="form-row">

    <div class="form-group col-sm-1 d-none d-sm-none d-md-none d-lg-block">
      <a href="index.php">
        <img src="img/aborn-logo.jpg" alt="Aborn_and_company" class="shrinkyDink">
      </a>
    </div>

    <!-- form input for SCAC -->
    <div class="form-group col-2 offset-1">
      <label for="SCACInput">SCAC
      <a href="scac.php?name=a" data-toggle='tooltip' data-placement='top' title='Click to find your SCAC'><i class="far fa-question-circle"></i></a></label>
      <div class="shadow">
        <input type="text" name="scac" class="form-control" id="SCACInput" value="<?php echo( isset($_SESSION['inputScac'])) ? $_SESSION['inputScac'] : ""; ?>">
      </div>
    </div>


      <!-- form input for PRO -->
    <div class="form-group col-8">
      <label for="PROInput">PRO Number(s)</label>
      <div class="input-group shadow">
        <input type="text" name="pros" class="form-control" id="PROInput" value="<?php echo( isset($_SESSION['pros'])) ? $_SESSION['pros'] : ""; ?>" class="">
        <div class="input-group-append">
          <button class="input-group-text" name="SubmitButton" type="submit" id='search'><a href="#"><i class="fas fa-arrow-right"></i></a></button>
        </div>
      </div>
    </div>
  </div> <!-- /.form-row -->
</form><!-- /form -->

