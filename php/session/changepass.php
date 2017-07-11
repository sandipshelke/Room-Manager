<?php
  include '../ConnectDb.php';
  include '../CommonFunctions.php';
  $RequestMethod=$_SERVER['REQUEST_METHOD'];
  $reqParameter=["upass"];
  if(!strcmp($RequestMethod,'POST'))
  {   
      try
      {
          $json = file_get_contents('php://input');
          $myarray=json_decode($json,true);
          validateInputData($myarray,$reqParameter);
          checkArrayNotEmpty($myarray);
          $LoggedUser=GetLoggedUserId();
          $sql ='UPDATE id827711_rmanager.member_registration
                 SET user_pass=? WHERE member_id=?';
          $stmt= $connect->prepare($sql);
          $stmt->bind_param("ss",$myarray['upass'],$LoggedUser);
          if ($stmt->execute()) 
           {
              if($stmt->affected_rows>0)
                $ResultStatus=WriteResponse("","","Password Changed",True);
           }else
               throw new Exception("Update Failed");         
        
       }catch(Exception $e)
        {  
            $ResultStatus= WriteResponse("500",'Failed',$e->getMessage(),false);
            header("HTTP/1.0 500 Internal Server Error");
        }
            
        echo json_encode($ResultStatus);
        $stmt->close();
    
  }
?>