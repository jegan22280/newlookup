<?php



require_once 'includes/databaseConnection.php';
require_once 'includes/sessions.php';
require_once 'includes/functions.php ';
require_once 'includes/header.php';


// variable declaration

?>

  <nav class="navbar navbar-expand-md navbar-default fixed-top">
    <!-- adding the header form -->
    <div class="mx-auto mt-1" style="width:50%;">
      <?php require 'includes/headForm.php' ?>
    </div>
  </nav>


<div class="container" style="margin-top:10rem">
  <div class="row">
    <div class="col-lg-6 offset-3">
      <form class="" action="sendInquiry.php"method="post">
        <div class="text-center mb-4 mt-1">

            <h1 class="h3 mb-3 font-weight-normal"></a>Carrier Inquiry</h1>
        </div>


        <!-- form group 1 -->
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
              <input type="text" name="contactUser" class="form-control" placeholder="Name" required autofocus>
          </div>
        </div>

        <!-- form group 2 -->
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
              <input type="email" name="contactEmail" class="form-control" placeholder="Email" required autofocus>
          </div>
        </div>

        <!-- message area -->
        <div class="form-group">
            <textarea name="contactMessage" class="form-control" placeholder=" Message"rows="6" required autofocus></textarea>
        </div>

        <!-- button -->
        <div class="">
          <button class="btn btn-primary px-5" type="submit" name="submit">Send</button>
        </div>
      </form>
    </div>
  </div>
</div>

      <?php  require 'includes/footer.php'  ?>
