<?php

function redirect_to($navLocation){
  header('Location:'.$navLocation);
  exit;
}

function testUserInput($inputData){
        return $inputData;
    }

?>
