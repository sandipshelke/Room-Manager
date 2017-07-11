<?php
  include '../ConnectDb.php';
  include '../CommonFunctions.php';
  $RequestMethod=$_SERVER['REQUEST_METHOD'];
  if(!strcmp($RequestMethod,'POST'))
  {   
      $loginFlag=false;$userkey="";
      try
      {
          $json = file_get_contents('php://input');
          $myarray=json_decode($json,true);
          $sql ='SELECT member_id,user_pass FROM id827711_rmanager.member_registration where email_id=?';
          $stmt= $connect->prepare($sql);
          $stmt->bind_param("s",$myarray['uname']);
          if ($stmt->execute()) 
           {
              $stmt->bind_result($userkey,$encsecret);
              $stmt->fetch();
              $loginFlag=password_verify($myarray['upass'],$encsecret); 
           }          
        
        if($loginFlag==true)
        {
          SetSessionVariables($userkey);
          echo('/Profile.html');
        }
        else
          throw new Exception("Invalid Username/Password");

       }catch(Exception $e)
        {
          header("HTTP/1.0 500 Internal Server Error");
          echo 'Message: ' .$e->getMessage();
        }

    
  }
?>