
<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  //$member_key=getLoggedUser();
  $groupInfo=array(
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
        $sql = "select u.name,u.email,u.birthdate,u.telephone
                    from `id827711_rmanager`.`User_Registration`as u
                    INNER JOIN `id827711_rmanager`.`GroupLookup` as g ON g.MemberId=u.keyid
                    where g.GroupId='$groupId'";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
               $tempArr["MemberName"]=$row["name"];
               $tempArr["UserMail"]=$row["email"];
               $tempArr["BirthDate"]=$row["birthdate"];
               $tempArr["UserMobile"]=$row["telephone"];
               array_push($testArray,$tempArr);
            }
            $groupInfo['ReqStatus']=true;
        }
        else
          {  throw new Exception; }

          $groupInfo['MemberList']=$testArray;
          echo json_encode($groupInfo);

      }catch(Exception $e)
      {  header('HTTP/1.0 internal server error '.$e); }
       
  }
?>