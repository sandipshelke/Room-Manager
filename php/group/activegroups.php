<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  //$member_key=getLoggedUser();
  $groupInfo=array(
     "ReqStatus"=>false,
     "ActiveList"=>array()
  );
  $testArray=array();
  $tempArr=array();
  if(!strcmp($_SERVER["REQUEST_METHOD"],"GET"))
  {
    try{
        $sql="SELECT * FROM `id827711_rmanager`.`groupinfo`";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
               $tempArr["GroupId"]=$row["grpid"];
               $tempArr["GroupName"]=$row["groupname"];
               $tempArr["AdminEmail"]=$row["adminemail"];
               $tempArr["MemberCount"]=$row["memberount"];
               array_push($testArray,$tempArr);
            }
            $groupInfo['ReqStatus']=true;
            $groupInfo['ActiveList']=$testArray;
            echo json_encode($groupInfo);
        }
        else
          {  throw new Exception("No group exists."); }

      }catch(Exception $e)
      { 
        $ResultStatus= WriteResponse("500",$e->getMessage(),'Failed',false);
        echo json_encode($ResultStatus);
        header("HTTP/1.0 500 Internal Server Error");
      }
       
  }

  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    try{
        $data = json_decode(file_get_contents('php://input'), true);
        $GroupId=$data['GroupId'];
        $sql="select * from `id827711_rmanager`.`groupinfo` where grpid='$GroupId'";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
               $tempArr["GroupId"]=$row["grpid"];
               $tempArr["GroupName"]=$row["groupname"];
               $tempArr["AdminEmail"]=$row["adminemail"];
               $tempArr["MemberCount"]=$row["memberount"];
               $tempArr["GroupDisc"]=$row["GroupDiscription"];
               array_push($testArray,$tempArr);
            }
            $groupInfo['ReqStatus']=true;
        }
        else
          {  throw new Exception; }

          $groupInfo['ActiveList']=$testArray;
          echo json_encode($groupInfo);

      }catch(Exception $e)
      {  header('HTTP/1.0 internal server error '.$e); }
       
  }
?>