<?php

$link = mysqli_connect("localhost", "root", "", "data_scrap");

$page  = $_GET['page']; // get the requested page 
$limit = $_GET['rows']; // get how many rows we want to have into the grid 
$sidx  = $_GET['sidx']; // get index row - i.e. user click to sort 
$sord  = $_GET['sord']; // get the direction 
if(!$sidx)
    $sidx  = 1;

$responce;
//search function ..................................
//echo "<pre>";
//print_r($_REQUEST);
//die;
$whereSearch = "WHERE 1 = 1 ";
if($_REQUEST['_search']=='true')
{
    if(empty($_REQUEST['filters']))
    {
        $search      = $_REQUEST['searchString'];
        $operations  = array(
            'eq'=>"= '".$search."'", // Equal
            'ne'=>"<> '".$search."'", // Not equal
            'lt'=>"< '".$search."'", // Less than
            'le'=>"<= '".$search."'", // Less than or equal
            'gt'=>"> '".$search."'", // Greater than
            'ge'=>">= '".$search."", // Greater or equal
            'bw'=>"like '%".$search."%%'", // Begins With
            'bn'=>"not like '%".$search."%%'", // Does not begin with
            'in'=>"in ('%".$search."')", // In
            'ni'=>"not in ('%".$search."')", // Not in
            'ew'=>"like '%%%".$search."'", // Ends with
            'en'=>"not like '%%%".$search."'", // Does not end with
            'cn'=>"like '%%%".$search."%%'", // Contains
            'nc'=>"not like '%%%".$search."%%'", // Does not contain
            'nu'=>"is null", // Is null
            'nn'=>"is not null"        // Is not null
        );
        $whereSearch = "where ".$_REQUEST['searchField']." ".$operations[$_REQUEST['searchOper']]."";
    }
    else
    {
        $whereSearch = "where ";
        $dataArray   = json_decode($_REQUEST['filters']);
        $data        = $dataArray->rules;
        foreach($data as $key=> $value)
        {
            $whereSearch.= $value->field." LIKE '%".$value->data."%' AND ";
        }
        $whereSearch = rtrim($whereSearch,'AND ');
        
    }
}

//...................................................
//$result = mysqli_query($link,"SELECT COUNT(*) AS count FROM data1");
$result = mysqli_query($link, "SELECT COUNT(*) AS count FROM data1 ".$whereSearch);
//echo "SELECT COUNT(*) AS count FROM data1 ".$whereSearch;
////die;
$row    = mysqli_fetch_array($result);

$count = $row['count'];

if($count>0)
{
    $total_pages = ceil($count/$limit);
}
else
{
    $total_pages = 0;
}

$start = 0;
if($page>$total_pages)
    $page = $total_pages;

if($count>0)
{
    $start = $limit*$page-$limit;
}
//else
//{
//    $start = 0;
//}

$SQL    = "SELECT id,name,url,regional FROM data1 ".$whereSearch." ORDER BY $sidx $sord LIMIT $start , $limit";
//echo $SQL;
//die;
$result = mysqli_query($link, $SQL)
        or die("Couldn t execute query.".mysqli_error());

$i = 0;
if(mysqli_num_rows($result)>'0')
{
    while($row = mysqli_fetch_assoc($result))
    {
        $responce->rows[$i]['id']   = $row['id'];
        $responce->rows[$i]['cell'] = array($row['id'], $row['name'], $row['url'], $row['regional']);
        $i++;
    }
    $responce->page    = $page;
    $responce->total   = $total_pages;
    $responce->records = $count;
}
else
{
    $responce['page']    = $page;
    $responce['total']   = $total_pages;
    $responce['records'] = $count;
}
echo json_encode($responce);
?>
