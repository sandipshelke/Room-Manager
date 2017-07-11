
<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  //$member_key=getLoggedUser();
  $userInfo=array(
     "ReqStatus"=>false,
     "MemberList"=>array()
  );
  $testArray=array();
  $tempArr=array();

  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    $arr=json_decode(file_get_contents('php://input'));
    $groupId=$arr->GroupId;
    try{
        $sql = "select m.member_id, m.first_name,m.email_id,m.DOB,m.mobile_no
                    from `id827711_rmanager`.`member_registration` as m
                    INNER JOIN `id827711_rmanager`.`grouplookup` as g ON g.MemberId=m.member_id
                    where g.GroupId='$groupId'";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
               $tempArr["MemberId"]=$row["member_id"];
               $tempArr["MemberName"]=$row["first_name"];
               $tempArr["UserMail"]=$row["email_id"];
               $tempArr["BirthDate"]=$row["DOB"];
               $tempArr["UserMobile"]=$row["mobile_no"];
               array_push($testArray,$tempArr);
            }
            $userInfo['ReqStatus']=true;
            $userInfo['MemberList']=$testArray;
            echo json_encode($userInfo);
        }
        else
          {  throw new Exception("No Members found."); }

      }catch(Exception $e)
      {  $ResultStatus= WriteResponse("500",$e->getMessage(),'Failed',false);
         header("HTTP/1.0 500 Internal Server Error");
         echo json_encode($ResultStatus);
      }
       
  }
?>