<?php
    session_start();
    $ResponseArray=array(
        "ErrorInfo"=>array(
            "ErrorCode"=>"",
            "ErrorMessage"=>"",
        ),
        "Message"=>"",
        "Status"=>false
    );

   function checkArrayNotEmpty($inputArray)
   {
        if(!empty($inputArray))
        {
            foreach($inputArray as $key=>$value)
                {
                    if(empty($value) || $value == NULL || $value == "")
                        throw new Exception("Please enter Value: ".$key);
                }
        }else{
            throw new Exception();
        }
        
    }
      
    function validateInputData($inputData, $reqParameters)
    {
        for($index=0; $index<sizeof($inputData); $index++)
        {
            if (!array_key_exists($reqParameters[$index],$inputData))
            throw new Exception(" Enter/Check ".$reqParameters[$index]);
        }
    }
 
 
   function WriteResponse($errorCode,$errorInfo,$meassage,$status)
   {
       $ResponseArray["ErrorInfo"]["ErrorCode"]=$errorCode;
       $ResponseArray["ErrorInfo"]["ErrorMessage"]=$errorInfo;
       $ResponseArray["Message"]=$meassage;
       $ResponseArray["status"]=$status;
       return $ResponseArray;
   }
   
   function CheckLogin(){
       session_start();
       if(!isset($_SESSION["user_session"]))
        {
            header('Location:../../index.html');
            header("HTTP/1.0 500 session expired");
            exit();
         }  
         
   }

   function SetSessionVariables($userid)
   {
        $_SESSION["user_session"]=true;
        $_SESSION['user_id']=$userid;
   }

   function GetLoggedUserId(){
       if(isset($_SESSION["user_session"]))
          return $_SESSION['user_id'];
        else
          return "";
   }

    function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    } 

    function emptyElementExists($arr) {
        return array_search("", $arr) !== false;
    }
    
    function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }



?>
