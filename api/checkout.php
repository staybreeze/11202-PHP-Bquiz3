<?php include_once "db.php";

// sort 函數會按照數值的順序（升序）重新排列陣列。
// 這裡是將 $_POST['seats'] 陣列的元素按照字母順序或數值大小進行排序。
sort($_POST['seats']);
// serialize 函數將整個陣列序列化成一個字串
$_POST['seats']=serialize($_POST['seats']);
$id=$Order->max('id')+1;
$_POST['no']=date("Ymd").sprintf("%04d",$id);
$Order->save($_POST);
echo $_POST['no'];