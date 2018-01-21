<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Allow-Credentials:true'); 
header("Content-Type: application/json;charset=utf-8"); 

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
	search();
} elseif (!empty($_POST["n"])){
	if($_POST["n"]=="q")
	delet();
	else modify();
}else{create();}
function search(){
	//先把query string中的查询变量名称取出
	$string=$_SERVER["QUERY_STRING"];
	$pattern="=";
	$limit=3;
	$str_before =split($pattern,$string,$limit);
	if (!isset($_GET[$str_before[0]]) || empty($_GET[$str_before[0]])) {
		echo '{"success":false,"msg":"Please enter..."}';
		return;
	}
	$arr= array();
	$conn = mysql_connect("localhost","root","") or die("error connecting");
	mysql_query("set names 'utf8'");
	mysql_select_db("eqm");
    $search= $_GET[$str_before[0]];
	$sql="SELECT * FROM info where $str_before[0]='$search'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)<1)
	{echo '{"success":false,"msg":"No result!"}';
		return;
	}
	while($rows=mysql_fetch_assoc($result)){
$arr[]=$rows;
  }    echo '{"success":true,"msg":'.json_encode($arr).'}';
mysql_close();

}
function create(){
	//判断信息是否填写完全
	if (!isset($_POST["name"]) || empty($_POST["name"])
		|| !isset($_POST["number"]) || empty($_POST["number"])
		|| !isset($_POST["lastCalibrationDate"]) || empty($_POST["lastCalibrationDate"])
		|| !isset($_POST["nextCalibrationDate"]) || empty($_POST["nextCalibrationDate"])
		|| !isset($_POST["calibrationInterval"]) || empty($_POST["calibrationInterval"])) {
		echo '{"success":false,"msg":"Please fill in all the blanks"}';
		return;
	}
	//TODO: 获取POST表单数据并保存到数据库

        $number=$_POST["number"];  
        $name=$_POST["name"];  
        $lastCalibrationDate=$_POST["lastCalibrationDate"];  
		$nextCalibrationDate=$_POST["nextCalibrationDate"];
		$calibrationInterval=$_POST["calibrationInterval"];
        $conn=mysql_connect('localhost','root','') or die("error connecting");  
        mysql_query("set names 'utf8'");
        mysql_select_db("eqm");
        $sql="INSERT INTO info values('$number','$name','$lastCalibrationDate','$nextCalibrationDate','$calibrationInterval')";  
		mysql_query($sql);
mysql_close();
		echo '{"success":true,"msg":"Number：' . $_POST["number"] . ' is saved！"}'; //关闭MySQL连接
	//提示保存成功

} 
function delet(){
if (!isset($_POST["name"]) || empty($_POST["name"])
		|| !isset($_POST["number"]) || empty($_POST["number"])
		|| !isset($_POST["lastCalibrationDate"]) || empty($_POST["lastCalibrationDate"])
		|| !isset($_POST["nextCalibrationDate"]) || empty($_POST["nextCalibrationDate"])
		|| !isset($_POST["calibrationInterval"]) || empty($_POST["calibrationInterval"])) {
		echo '{"success":false,"msg":"Please fill in all the blanks"}';
		return;
	}
	$conn=mysql_connect('localhost','root','') or die("error connecting"); 
	mysql_query("set names 'utf8'");
    mysql_select_db("eqm");
	$number=$_POST["number"];  
    $delet="DELETE FROM info WHERE number='$number'";
    mysql_query($delet);
    if((mysql_affected_rows()==0)||(mysql_affected_rows()==-1))
        echo'{"success":false,"msg":"The information is wrong, please enter again."}';
    else echo'{"success":true,"msg":"This equipment is deleted!"}';
	mysql_close();
}
function modify(){
	if (!isset($_POST["name"]) || empty($_POST["name"])
		|| !isset($_POST["number"]) || empty($_POST["number"])
		|| !isset($_POST["lastCalibrationDate"]) || empty($_POST["lastCalibrationDate"])
		|| !isset($_POST["nextCalibrationDate"]) || empty($_POST["nextCalibrationDate"])
		|| !isset($_POST["calibrationInterval"]) || empty($_POST["calibrationInterval"])) {
		echo '{"success":false,"msg":"Please fill in all the blanks"}';
		return;
	}
	$conn=mysql_connect('localhost','root','') or die("error connecting"); 
	mysql_query("set names 'utf8'");
    mysql_select_db("eqm");
	$number=$_POST["number"];
	$name=$_POST["name"];  
	$lastCalibrationDate=$_POST["lastCalibrationDate"];  
	$nextCalibrationDate=$_POST["nextCalibrationDate"];
	$calibrationInterval=$_POST["calibrationInterval"];
	  
    $Modify="UPDATE info SET name = '$name',lastCalibrationDate = '$lastCalibrationDate',nextCalibrationDate = '$nextCalibrationDate',calibrationInterval = '$calibrationInterval' WHERE number = '$number'";
    mysql_query($Modify);
	mysql_close();
    echo'{"success":true,"msg":"This equipment is modified!"}';
	
	
}
?>
