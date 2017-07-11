<?php
  $connect=new mysqli("localhost","root","Sandy111@");
  //$connect=new mysqli("localhost","id2069973_root","Sandy111@");

  if($connect->error)
  {
    echo "Error: ".$connect->error;
  }

?>