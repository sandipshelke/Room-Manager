
<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  $ExpInfo=array(
     "ReqStatus"=>false,
     "AllExpList"=>array(
       "RoomRent"=>"0",
       "LightBill"=>"0",
       "Internet"=>"0"
     )
  );
  $testArray=array();
  $tempArr=array();
  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    $arr=json_decode(file_get_contents('php://input'));
    $groupId=$arr->GroupId;
    $monthId=$arr->MonthId;
    $MemberCount=getMemberCount($groupId);
    
    try{
        $sql = "SELECT m.member_id, m.first_name,c.roomrent,c.lightbill,c.internet, e.month,e.other,e.discription FROM id827711_rmanager.CommonExp as c
                  INNER JOIN `id827711_rmanager`.`expenses` as e
                  ON e.month=c.monthid
                  INNER JOIN id827711_rmanager.member_registration as m
                  ON m.member_id =e.Key
                  where c.GroupId='$groupId' AND c.monthid='$monthId'";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
               $tempArr["MemberId"]=$row["member_id"];
               $tempArr["MemberName"]=$row["first_name"];
               $tempArr["RoomRent"]=((int)$row["roomrent"])/$MemberCount;
               $tempArr["LightBill"]=((int)$row["lightbill"])/$MemberCount;
               $tempArr["Internet"]=((int)$row["internet"])/$MemberCount;
               $tempArr["Other"]=$row["other"];
               $tempArr["Reason"]=$row["discription"];
               array_push($testArray,$tempArr);
            }
            $ExpInfo['ReqStatus']=true;
            $ExpInfo['AllExpList']=$testArray;
        }
        echo json_encode($ExpInfo);

      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",$e->getMessage(),"Failed",false);
        header("HTTP/1.0 500 Internal Server Error");
      }
       
  }

  function getMemberCount($groupId)
  {
        include '../ConnectDb.php';
        $MemberCount=0;
        $sql = "SELECT COUNT(*) as MemberCount FROM `id827711_rmanager`.`grouplookup`
                where GroupId='$groupId'";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                $MemberCount=(int)$row["MemberCount"];
            }

        }
      return $MemberCount;
  }
?>