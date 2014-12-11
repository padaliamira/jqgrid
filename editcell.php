<?php 
$link = mysqli_connect("localhost", "root", "", "data_scrap");
if(array_key_exists('name',$_REQUEST))
{
    $field = 'name';
}
elseif(array_key_exists('url',$_REQUEST))
{
    $field = 'url';
}
elseif(array_key_exists('regional',$_REQUEST))
{
    $field = 'regional';
}
$updateCellQuery = "update data1 set ".$field." = '".$_REQUEST[$field]."' where id = '".$_REQUEST['id']."'";
mysqli_query($link, $updateCellQuery);
?>
