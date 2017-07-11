<?php
  include_once '../ConnectDb.php';
  include'../CommonFunctions.php';
  $jsonArray = array();
  $key=GetLoggedUserId();
  $sql="Select * FROM `id827711_rmanager`.`member_registration` where member_id=\"$key\"";

  $result=$connect->query($sql);

  if($result->num_rows>0)
  {
     while($row=$result->fetch_assoc())
     {
        $jsonArrayItem = array();
        $jsonArrayItem["Name"]=$row["first_name"];
        $jsonArrayItem["Email"]=$row["email_id"];
        $jsonArrayItem["Mobile"]=$row["mobile_no"];
        $jsonArrayItem["Profession"]=$row["profession"];
        $jsonArrayItem["AboutMe"]=$row["aboutme"];
        $jsonArrayItem["DOB"]=$row["DOB"];
        $jsonArrayItem["Gender"]=$row["Gender"];
        $jsonArrayItem["Address"]=$row["Address"];
        array_push($jsonArray, $jsonArrayItem); 
     }     
  }

  echo json_encode($jsonArray);
?>