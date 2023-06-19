<?php require 'includes/header.php' ?>
<?php require 'includes/databaseConnection.php' ?>
<?php $searchQueryParameter = $_GET['name'].'%';?>


<div class="container">
  <div class="row">
    <div class="col-12 mt-3">
      <?php require 'includes/headForm.php' ?>


    </div>
  </div>


  <div class="row">


    <div class="col-sm-10 offset-1">
      <?php for ($i=65; $i <91 ; $i++) {
        $letter=chr($i);
        $html ='<h4 class="d-inline mr-2 text-center"><a href="scac.php?name='.$letter.'">'.$letter.'</a></h4>';
        echo $html;
      }
       ?>

      <table class="table table-hover table-sm mt-3">

        <thead>
          <tr>
            <th scope="col">SCAC</td>
            <th scope="col">Carrier name</td>
            <th scope="col">City</td>
            <th scope="col">State</td>
          </tr>
        </thead>
        <tbody>

        <?php



        $scacQuery = $conn->prepare("SELECT SCAC, CARRIER, CITY, STATE, PROFORM FROM carrier WHERE CARRIER like ?");

        if($scacQuery->execute(array($_GET['name'].'%')))
          while($row = $scacQuery->fetch()) {
        ?>

          <tr>
            <td><?php echo $row["SCAC"] ?></td>
            <td><?php echo $row["CARRIER"] ?></td>
            <td><?php echo $row["CITY"] ?></td>
            <td><?php echo $row["STATE"] ?></td>
          </tr>

        <?php
            }
           // }
         ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require 'includes/footer.php' ?>
