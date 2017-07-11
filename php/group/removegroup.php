<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    try{
        $data = json_decode(file_get_contents('php://input'), true);
        $sql = "DELETE FROM `id827711_rmanager`.`groupinfo` WHERE grpid=?"; 
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("s",$data['GroupId']);
       if(!strcmp($stmt->execute(),true))
        {
            $ResultStatus["Status"]=true;
            $ResultStatus["ErrorInfo"]="";
            $ResultStatus["Message"]="Group Removed";
        } 
        else
          { 
               throw new Exception("Unable to remove group");
          }
         
          echo json_encode($ResultStatus);

      }catch(Exception $e)
      {  header('HTTP/1.0 internal server error '.$e->getMessage() ); }
       
       $stmt->close();
  }
?>