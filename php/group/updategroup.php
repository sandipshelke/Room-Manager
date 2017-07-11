<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    try{
        $data = json_decode(file_get_contents('php://input'), true);

        $sql = "UPDATE `id827711_rmanager`.`groupinfo`
                 SET groupname=?,adminemail=?,GroupDiscription=? WHERE grpId=?"; 
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ssss",$data['GroupName'],$data['AdminEmail'],$data['GroupDisc'],$data['GroupId']);
       if(!strcmp($stmt->execute(),true))
          $ResultStatus= WriteResponse("","","Group Updated",true);
       else
          throw new Exception("Unable to update group");

      }catch(Exception $e)
      {
         $ResultStatus= WriteResponse("500",$e->getMessage(),"Failed",false);
         header("HTTP/1.0 500 Internal Server Error");
      }
       
       echo json_encode($ResultStatus);
       $stmt->close();
  }
?>