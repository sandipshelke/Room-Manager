<?php
  header("Content-type:application/json");
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';
  
  if(!strcmp($_SERVER["REQUEST_METHOD"],"POST"))
  {
    try{
        $GroupDataType=["MonthId","GroupId","RoomRent","LightBill","Internet"];
        $data = json_decode(file_get_contents('php://input'), true);
        validateInputData($data,$GroupDataType);
        if(checkRecordAExistForMonth($data['MonthId'],$data['GroupId']))
          $ResultStatus=UpdateRecordForMonth($data);
        else
          $ResultStatus=AddRecordForMonth($data);
      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",$e->getMessage(),"Failed",false);
        header("HTTP/1.0 500 Internal Server Error");
      }
          
       echo json_encode($ResultStatus);
  }

  function checkRecordAExistForMonth($month,$GroupId)
  {
    include '../ConnectDb.php';
    $sql="SELECT * FROM `id827711_rmanager`.`CommonExp` WHERE monthid='$month' AND GroupId='$GroupId'";
    $result = $connect->query($sql); 
      if ($result->num_rows >0)             
         return true;
         
      return false;
  }


  function  AddRecordForMonth($data)
  {    
        include '../ConnectDb.php';
        $sql = "INSERT INTO `id827711_rmanager`.`commonexp` (`roomrent`,`lightbill`,`internet`,`GroupId`,`monthid`)
               VALUES(?,?,?,?,?)"; 
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sssss",$data['RoomRent'],$data['LightBill'],$data['Internet'],$data['GroupId'],$data['MonthId']);
       
        if(!strcmp($stmt->execute(),true))
            $ResultStatus= WriteResponse("","","Expenses Added",true);
        else
          throw new Exception("Unable to Add Expenses");
        $stmt->close();
       
       return $ResultStatus;
  }

  function  UpdateRecordForMonth($data)
  {     
        include '../ConnectDb.php';
        $sql = "UPDATE `id827711_rmanager`.`CommonExp`  SET
                roomrent=?,lightbill=?,internet=?
                Where monthid=? AND GroupId=?"; 
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sssss",$data['RoomRent'],$data['LightBill'],$data['Internet'],$data['MonthId'],$data['GroupId']);
       
        if(!strcmp($stmt->execute(),true))
            $ResultStatus= WriteResponse("","","Expenses Updated",true);
        else
          throw new Exception("Unable to Update Expenses");
        $stmt->close();

        return $ResultStatus;
  }

?>