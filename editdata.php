<?php 
$link = mysqli_connect("localhost", "root", "", "data_scrap");
if ( $_REQUEST["oper"] == "add" )
{
    $insertQuery = "insert into data1(name,url,regional) values('".$_REQUEST['name']."','".$_REQUEST['url']."','".$_REQUEST['regional']."')";
    mysqli_query($link, $insertQuery);
}

elseif($_REQUEST["oper"] == "edit")
{
    $updateQuery = "update data1 set name = '".$_REQUEST['name']."',url = '".$_REQUEST['url']."',regional ='".$_REQUEST['regional']."' where id = '".$_REQUEST['id']."'";
    mysqli_query($link, $updateQuery);
}

elseif($_REQUEST["oper"] == "del")
{
    $deleteQuery = "delete from data1 where id in (".$_REQUEST['id'].")";
    mysqli_query($link, $deleteQuery);
}
?>
