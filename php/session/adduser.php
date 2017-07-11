<?php
  include '../ConnectDb.php';
  include '../CommonFunctions.php';
  include_once '../mailer/SendEmail.php';

  $RequestMethod=$_SERVER['REQUEST_METHOD'];

  if(!strcmp($RequestMethod,'POST'))
  {   
      $loginFlag=false;$message="";
      try
      {
          $json = file_get_contents('php://input');
          $myarray=json_decode($json,true);

          checkArrayNotEmpty($myarray);
          $emailId=$myarray['email'];
          $sql ="SELECT * FROM id827711_rmanager.member_registration WHERE email_id='$emailId'";
          $result= $connect->query($sql);
          if ($result->num_rows>0)
            throw new Exception("Email already registered"); 
          $guid=getGUID();
          if(array_key_exists("GroupId",$myarray))
          {
            $grpId=$myarray["GroupId"];
            $sql="INSERT INTO `id827711_rmanager`.`grouplookup`VALUES('$grpId','$guid')";
            if(!$connect->query($sql))
              throw new Exception("Unable to map member."); 
          }
          $sql ='INSERT INTO id827711_rmanager.member_registration(member_id,first_name,email_id,user_pass,VarifiCode) 
                 VALUES(?,?,?,?,?)';
          $stmt= $connect->prepare($sql);
          $secret=rand(0,10000);
          $tempPass=hashPassword($secret);
          $varCode = md5( rand(0,1000) );
          $stmt->bind_param("sssss",$guid,$myarray['fname'],$myarray['email'],$tempPass,$varCode);
          if ($stmt->execute()) 
          {
              $msgbody="http://gadvede.comxa.com/php/session/activateaccount.php?VarCode=".$varCode."<br><br>Temporary Password:".$secret;
              $sentStatus=CreateMailBodyAndSendMail($myarray['email'],$msgbody);
              if($sentStatus)
              {
                $response = "Email with varification link has been sent to your email address.Please verify it to activate account.";
                $ResultStatus=WriteResponse("","",$response,True);
                SetSessionVariables($guid);
              }
              else
                throw new Exception("Unable to send Varification Email");   
          }     
          else
            throw new Exception("Failed:".$stmt->error);

      }catch(Exception $e)
      {  
        $ResultStatus= WriteResponse("500",'Failed',$e->getMessage(),false);
        header("HTTP/1.0 500 Internal Server Error");
      }
          
       echo json_encode($ResultStatus);
       $stmt->close();
   
  }


  function CreateMailBodyAndSendMail($mailId,$msgbody){
   
          $msgbody='<html>
                      <head>
                          <title>Welcome to Trecking</title>
                      </head>
                      <body style="background-color: #f5f5f5;font-family: verdana;font-size: 14px;padding:5px;">
                          <h3>Thanks you for joining with us!</h3>
                          <p>click link below to activate your account</p>
                          <div>
                              <p>'.$msgbody.'</p>
                          </div>
                      </body>
                  </html>';

          $sentStatus=SendMyMail($mailId,'Account Varification',$msgbody);
          return $sentStatus;
  }

?>