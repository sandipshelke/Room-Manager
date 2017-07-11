<?php
  include_once '../ConnectDb.php';
  include_once '../CommonFunctions.php';

  $Req_Method=$_SERVER["REQUEST_METHOD"];
  if(strcmp($Req_Method,"GET"))
  {
    $array=array();
    $sql="select * from `id827711_rmanager`.`commonexp` where monthid=1";
    $request=$connect->query($sql);
    if($request->num_rows>0)
    {
        $jsonarr =array();
        while($row=$result->fetch_assoc())
        {
            $jsonarr=
        }
    }
  }
?>