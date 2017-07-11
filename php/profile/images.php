<?php
    include '../CommonFunctions.php';

    $RequestMethod=$_SERVER['REQUEST_METHOD'];
    if(!strcmp($RequestMethod,'POST'))
    {   
        try
        {
            
            $imageName=addslashes($_FILES["image"]["name"]);
            $imageData=addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
            $imageType=addslashes($_FILES["image"]["type"]);
            if(substr($imageType,0,5)=="image")
            {
                $imageId=getGUID();
                $UserId=GetLoggedUserId();
                if(CheckImageExist($UserId))
                    UpdateImage($imageId,$UserId,$imageType,$imageName,$imageData);
                else
                    SaveImage($imageId,$UserId,$imageType,$imageName,$imageData);
            }
            else
                throw new Exception("Please select valid image");

        }catch(Exception $e)
        {  
            header('Location: /Profile.html');
        }
            
    }

    if($RequestMethod=="GET"){
        try
        {
            header("content-type:image/jpg"); 
            if(isset($_GET["ImageId"]))
            {
               $imageId=$_GET["ImageId"];
               GetImage($imageId);
            }else
             {      
                $imageId=GetLoggedUserId();
                GetImage($imageId);
             }
       
        }catch(Exception $e)
        {  
        header('Location: /Profile.html');
        }
            
    }
    
    function SaveImage($imageId,$UserId,$imageType,$imageName,$imageData){
        
        require '../ConnectDb.php';
        
        $sql="INSERT INTO `id827711_rmanager`.`user_images` 
            VALUES('$imageId','$UserId','$imageType','$imageName','{$imageData}')";
    
        if($connect->query($sql)==TRUE)
           header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    
    function UpdateImage($imageId,$UserId,$imageType,$imageName,$imageData){
    
        require '../ConnectDb.php';
        
        $sql="UPDATE `id827711_rmanager`.`user_images` 
               SET
                `ImageType` = '$imageType',
                `ImageName` = '$imageName',
                `ImageContent` = '{$imageData}'
                WHERE 
                      UserId='$UserId'";
        if($connect->query($sql)==TRUE)
           header("Location: ".$_SERVER['HTTP_REFERER']);
    }
    
    function GetImage($UserId){
        require '../ConnectDb.php';
        $imageData;
        $sql="SELECT * FROM `id827711_rmanager`.`user_images`  WHERE UserId='$UserId'";
        //$sql="select * from a5780612_roomman.output_images";
        $result=$connect->query($sql);
        if($result->num_rows>0)
        {
          while($row=$result->fetch_array())
             $imageData=$row["ImageContent"];
        }
        else{
             $sql="SELECT * FROM `id827711_rmanager`.`user_images`  WHERE UserId='1'";
             $result=$connect->query($sql);
             while($row=$result->fetch_array())
                 $imageData=$row["ImageContent"];
        } 
        echo $imageData;
    }

    function CheckImageExist($UserId){
    
        require '../ConnectDb.php';
        
        $sql="SELECT * FROM `id827711_rmanager`.`user_images` WHERE `UserId`='$UserId'";
        $result=$connect->query($sql);
        if($result->num_rows>0)
           return true;
        else
            return false;
    }
?>