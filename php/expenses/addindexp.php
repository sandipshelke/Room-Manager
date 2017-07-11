<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    try{
        //$GroupDataType=["MonthId","GroupId","RoomRent","LightBill","Internet"];
        $data = json_decode(file_get_contents('php://input'), true);
        $guid=getGUID();
       // validateInputData($data,$GroupDataType);
        if(checkRecordAExistForMonth($data['MonthId'],$data['GroupId'],$data["MemberId"]))
          $ResultStatus=UpdateExprecordForMonth($data,$guid);
        else
          $ResultStatus=AddExprecordForMonth($data,$guid);
      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",$e->getMessage(),"Failed",false);
        header("HTTP/1.0 500 Internal Server Error");
      }
          
       echo json_encode($ResultStatus);
  }

  function checkRecordAExistForMonth($month,$GroupId,$memberid)
  {
    include '../ConnectDb.php';
    $sql="SELECT * FROM id827711_rmanager.expenses as e WHERE e.month='$month' AND e.GroupId='$GroupId' And e.Key='$memberid'";
    $result = $connect->query($sql); 
      if ($result->num_rows >0)             
         return true;
         
      return false;
  }


  function  AddExprecordForMonth($data,$guid)
  {    
        include '../ConnectDb.php';
        $sql = "INSERT INTO `id827711_rmanager`.`expenses`
                (`Key`,
                `roomrent`,
                `lightbill`,
                `Internet`,
                `other`,
                `discription`,
                `month`,
                `GroupId`,
                `ExpensesKey`)
                   VALUES(?,?,?,?,?,?,?,?,?)"; 
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sssssssss",$data['MemberId'],$data['RoomRent'],$data['LightBill'],$data['Internet'],$data['Other'],$data['Reason'],$data['MonthId'],$data['GroupId'],$guid);
       
        if(!strcmp($stmt->execute(),true))
            $ResultStatus= WriteResponse("","","Expenses Added",true);
        else
          throw new Exception("Unable to Add Expenses");
        $stmt->close();
       
       return $ResultStatus;
  }

  function  UpdateExprecordForMonth($data)
  {     
        include '../ConnectDb.php';
        $sql = "UPDATE `id827711_rmanager`.`expenses` as e  SET
                e.roomrent=?,e.lightbill=?,e.Internet=?,e.other=?,e.discription=?
                Where e.month=? AND e.GroupId=? AND e.Key=?";
                
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ssssssss",$data['RoomRent'],$data['LightBill'],$data['Internet'],$data['Other'],$data['Reason'],$data['MonthId'],$data['GroupId'],$data['MemberId']);
       
        if(!strcmp($stmt->execute(),true))
            $ResultStatus= WriteResponse("","","Expenses Updated",true);
        else
          throw new Exception("Unable to Update Expenses");
        $stmt->close();

        return $ResultStatus;
  }

?>