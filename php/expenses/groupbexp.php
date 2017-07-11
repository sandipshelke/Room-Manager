
<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  $ExpInfo=array(
     "ReqStatus"=>false,
     "CommonList"=>array(
       "RoomRent"=>"0",
       "LightBill"=>"0",
       "Internet"=>"0"
     ),
     "PendingExpenses"=>array()
  );
  $tempArr=array();

  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    $arr=json_decode(file_get_contents('php://input'));
    $groupId=$arr->GroupId;
    $monthId=$arr->MonthId;
    try{
        $sql = "SELECT roomrent, lightbill,internet FROM id827711_rmanager.CommonExp
                where GroupId='$groupId' AND monthid='$monthId'";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
               $tempArr["RoomRent"]=$row["roomrent"];
               $tempArr["LightBill"]=$row["lightbill"];
               $tempArr["Internet"]=$row["internet"];
            }
            $CommonExpInfo['ReqStatus']=true;
            $CommonExpInfo['CommonList']=$tempArr;
        }
        echo json_encode($CommonExpInfo);

      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",$e->getMessage(),"Failed",false);
        header("HTTP/1.0 500 Internal Server Error");
      }
       
  }
?>