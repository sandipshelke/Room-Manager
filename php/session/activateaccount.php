<?php
 include '../ConnectDb.php';
 if(isset($_GET['VarCode']))
 {
     try
     {
        $sql ='SELECT * FROM id827711_rmanager.member_registration where VarifiCode=?';
        $stmt= $connect->prepare($sql);
        $stmt->bind_param("s",$_GET['VarCode']);
        if ($stmt->execute()) 
        { 
            $stmt->store_result();
            if( $stmt->num_rows>0)
            {
                $varificationCode=$_GET['VarCode'];
                $sql_query="UPDATE id827711_rmanager.member_registration
                            SET VarifiCode=1 where VarifiCode='$varificationCode'";
                if ($connect->query($sql_query)==TRUE)
                {
                    getMyTemplete('<h3>Email Verification successfull.');
                    header('Refresh: 3; URL= http://gadvede.comxa.com/updateProfile.html');
                }
            } else
                throw new Exception();
        }          
     }catch(Exception $e)
     {  
         getMyTemplete('<h3>Email Verification Failed.');
         header('Refresh: 3; URL= http://gadvede.comxa.com/');
     }
         
 }else
     echo 'Invalid approach';


function getMyTemplete($message)
{
   $MessageBody =
    '<html>
        <head>
        <title>Email Varification</title>
        </head>
        <body style="font-family: verdana;  background-repeat: repeat-y;">
           <header><h2>Gadvede.com</h2></header>
            <div class=""  >
               <h6>'.$message.' please wait redirecting in........</h6>         
            </div>
        </body>   
   </html>';
   echo   $MessageBody;
}

?>