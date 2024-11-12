<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_visitor.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$floor_no = '';
$title = $_data['text_1'];
$button_text=$_data['save_button_text'];
$successful_msg=$_data['text_15'];
$form_url = WEB_URL . "visitor/addvisitor.php";
$id="";
$hdnid="0";
$floor_id = 0;
$unit_id = 0;
$name = '';
$mobile = '';
$address = '';
$intime = '';
$outtime = '';
$xdate = '';
$branch_id = '';
$issue_date = '';
if(isset($_POST['txtName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	$month = date('m');
	$year = date('Y');
	$sql = "INSERT INTO `tbl_visitor`(issue_date,name,mobile,address,floor_id,unit_id,intime,outtime,xmonth,xyear,branch_id) values('$_POST[txtIssueDate]','$_POST[txtName]','$_POST[txtMobile]','$_POST[txtAddress]','$_POST[ddlFloorNo]','$_POST[ddlUnitNo]','$_POST[txtInTime]','$_POST[txtOutTime]',$month,$year,'" . $_SESSION['objLogin']['branch_id'] . "')";
	mysql_query($sql,$link);
	mysql_close($link);
	$url = WEB_URL . 'visitor/visitorlist.php?m=add';
	header("Location: $url");
	
}
else{
	
	$sql = "UPDATE `tbl_visitor` SET `issue_date`='".$_POST['txtIssueDate']."',`name`='".$_POST['txtName']."',`mobile`='".$_POST['txtMobile']."',`address`='".$_POST['txtAddress']."',`floor_id`='".$_POST['ddlFloorNo']."',`unit_id`='".$_POST['ddlUnitNo']."',`intime`='".$_POST['txtInTime']."',`outtime`='".$_POST['txtOutTime']."' WHERE vid='".$_GET['id']."'";
	mysql_query($sql,$link);
	$url = WEB_URL . 'visitor/visitorlist.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysql_query("SELECT * FROM tbl_visitor where vid = '" . $_GET['id'] . "'",$link);
	while($row = mysql_fetch_array($result)){
		
		$issue_date = $row['issue_date'];
		$name = $row['name'];
		$mobile = $row['mobile'];
		$floor_id = $row['floor_id'];
		$unit_id = $row['unit_id'];
		$intime = $row['intime'];
		$outtime = $row['outtime'];
		$address = $row['address'];
		$hdnid = $_GET['id'];
		$title = $_data['text_16'];
		$button_text=$_data['update_button_text'];
		$successful_msg=$_data['text_17'];
		$form_url = WEB_URL . "visitor/addvisitor.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);

}	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_2'];?></li>
    <li class="active"><?php echo $_data['text_3'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>visitor/visitorlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_4'];?></h3>
      </div>
      
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
