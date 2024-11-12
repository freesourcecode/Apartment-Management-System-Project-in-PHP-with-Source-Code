<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_maintenance_cost.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$m_title = '';
$m_date = '';
$m_amount = '';
$m_details = '';
$m_month = 0;
$m_year = 0;
$branch_id = '';
$title = $_data['add_title_text'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['add_msg'];
$form_url = WEB_URL . "maintenance/add_maintenance_cost.php";
$id="";
$hdnid="0";

if(isset($_POST['txtMTitle'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){

	$sql = "INSERT INTO tbl_add_maintenance_cost(m_title, m_date, xmonth, xyear, m_amount, m_details,branch_id) values('$_POST[txtMTitle]','$_POST[txtMDate]','$_POST[ddlMonth]','$_POST[ddlYear]','$_POST[txtMAmount]','$_POST[txtMDetails]','" . $_SESSION['objLogin']['branch_id'] . "')";
	//echo $sql;
	//die();
	mysql_query($sql,$link);
	mysql_close($link);
	$url = WEB_URL . 'maintenance/maintenance_cost_list.php?m=add';
	header("Location: $url");
	
}
else{
	
	$sql = "UPDATE `tbl_add_maintenance_cost` SET `m_title`='".$_POST['txtMTitle']."',`m_date`='".$_POST['txtMDate']."',`xmonth`='".$_POST['ddlMonth']."',`xyear`='".$_POST['ddlYear']."',`m_amount`='".$_POST['txtMAmount']."',`m_details`='".$_POST['txtMDetails']."' WHERE mcid='".$_GET['id']."'";
	mysql_query($sql,$link);
	$url = WEB_URL . 'maintenance/maintenance_cost_list.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysql_query("SELECT * FROM tbl_add_maintenance_cost where mcid = '" . $_GET['id'] . "'",$link);
	while($row = mysql_fetch_array($result)){
		
		$m_title = $row['m_title'];
		$m_date = $row['m_date'];
		$m_amount = $row['m_amount'];
		$m_details = $row['m_details'];
		$m_month = $row['xmonth'];
		$m_year = $row['xyear'];
		$hdnid = $_GET['id'];
		$title = $_data['update_title_text'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_msg'];
		$form_url = WEB_URL . "maintenance/add_maintenance_cost.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);

}
	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>/dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['maintenance_cost'];?></li>
    <li class="active"><?php echo $_data['add_m_cost'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>maintenance/maintenance_cost_list.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['m_cost_entry_form'];?></h3>
      </div>
      
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
