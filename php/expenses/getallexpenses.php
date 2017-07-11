
<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  $ExpInfo=array(
     "ReqStatus"=>false,
     "ExpensesList"=>array()
  );
  $testArray=array();
  $tempArr=array();
  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    $arr=json_decode(file_get_contents('php://input'));
    $groupId=$arr->GroupId;
    $monthId=$arr->MonthId;    
    try{

        $sql = "SELECT m.member_id,m.first_name,e.Key,e.month,e.roomrent,e.lightbill,e.Internet,e.other,e.discription FROM `id827711_rmanager`.`expenses` as e
                INNER JOIN  id827711_rmanager.member_registration as m
                ON m.member_id=e.Key
                WHERE e.month='$monthId' AND e.GroupId='$groupId' ";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
               $tempArr["MemberName"]=$row["first_name"];
               $tempArr["RoomRent"]=$row["roomrent"];
               $tempArr["LightBill"]=$row["lightbill"];
               $tempArr["Internet"]=$row["Internet"];
               $tempArr["Other"]=$row["other"];
               $tempArr["Reason"]=$row["discription"];
               array_push($testArray,$tempArr);
            }
            $ExpInfo['ReqStatus']=true;
            $ExpInfo['ExpensesList']=$testArray;
            echo json_encode($ExpInfo);
        }else
          throw new Exception("No Data Exists.");

      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",$e->getMessage(),"Failed",false);
        echo json_encode($ResultStatus);
        header("HTTP/1.0 500 Internal Server Error");
      }
       
  }
?>