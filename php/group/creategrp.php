<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    try{
        $GroupDataType=["GroupName","GroupType","AdminEmail","GroupDisc"];
        $data = json_decode(file_get_contents('php://input'), true);
        validateInputData($data,$GroupDataType);
        $sql = "INSERT INTO `id827711_rmanager`.`groupinfo` (`grpid`, `groupname`,`GroupType`,`adminemail`,`GroupDiscription`) VALUES (?,?,?,?,?)"; 
        $stmt = $connect->prepare($sql);
        $guid=getGUID();
        $memberId=GetLoggedUserId();
        $stmt->bind_param("sssss",$guid,$data['GroupName'],$data['GroupType'],$data['AdminEmail'],$data['GroupDisc']);
       
        if(!strcmp($stmt->execute(),true))
        {
            $grpId=$myarray["GroupId"];
            $sql="INSERT INTO `id827711_rmanager`.`grouplookup`VALUES('$guid','$memberId')";
            if(!$connect->query($sql))
              throw new Exception("Unable to map member."); 
            $ResultStatus= WriteResponse("","","Group Created",true);
        }
        else
          throw new Exception("Unable to create group");

      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",$e->getMessage(),"Failed",false);
        header("HTTP/1.0 500 Internal Server Error");
      }
          
       echo json_encode($ResultStatus);
       $stmt->close();
  }
?>