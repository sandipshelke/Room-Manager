<?php
  include '../ConnectDb.php';
  include '../CommonFunctions.php';

  $RequestMethod=$_SERVER['REQUEST_METHOD'];

  if(!strcmp($RequestMethod,'POST'))
  {   
      $loginFlag=false;$message="";
      $reqParameter=["Bdate","Address","Mobile","Profession","AboutMe","Gender"];
      try
      {
          $json = file_get_contents('php://input');
          $myarray=json_decode($json,true);
         // validateInputData($myarray,$reqParameter);
          checkArrayNotEmpty($myarray);
          
          if($myarray['Gender']==true)
             $myarray['Gender']="M";
          else
             $myarray['Gender']="F";
          
          $LoggedUser=GetLoggedUserId();
          $sql ="UPDATE `id827711_rmanager`.`member_registration`
                    SET
                        `DOB` =?,
                        `Address` = ?,
                        `mobile_no` = ?,
                        `profession` = ?,
                        `aboutme` = ?,
                        `Gender` = ?
                        WHERE
                             `member_id` = ?";
         $stmt= $connect->prepare($sql);
         $stmt->bind_param("ssissss",$myarray['Bdate'],$myarray['Address'],$myarray['Mobile'],$myarray['Profession'],$myarray['AboutMe'],$myarray['Gender'],$LoggedUser);
          if ($stmt->execute()) 
          {
             if($stmt->affected_rows>0)
                $ResultStatus= WriteResponse("","","User Information Updated",true);
             else
                throw new Exception("No Change Detected");
          }     
          else
            throw new Exception("Unable to update information");

      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",'Failed',$e->getMessage(),false);
        header("HTTP/1.0 500 Internal Server Error");
      }
          
       echo json_encode($ResultStatus);
       $stmt->close();
  }

?>