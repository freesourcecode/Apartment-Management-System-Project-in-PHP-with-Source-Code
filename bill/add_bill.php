<?php

include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_bill.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$bill_type = '';
$bill_date = '';
$bill_month = '';
$bill_year = '';
$total_amount = '';
$deposit_bank_name = '';
$bill_details = '';
$branch_id = '';
$title = $_data['text_1'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['text_15'];
$form_url = WEB_URL . "bill/add_bill.php";
$id="";
$hdnid="0";

if(isset($_POST['ddlBillType'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
		$sql = "INSERT INTO tbl_add_bill(bill_type,bill_date,bill_month,bill_year,total_amount,deposit_bank_name,bill_details,branch_id) values('$_POST[ddlBillType]','$_POST[txtBillDate]','$_POST[ddlBillMonth]','$_POST[ddlBillYear]','$_POST[txtTotalAmount]','$_POST[txtDepositBankName]','$_POST[txtBillDetails]','" . $_SESSION['objLogin']['branch_id'] . "')";
		mysql_query($sql,$link);
		//mysql_close($link);
		$url = WEB_URL . 'bill/bill_list.php?m=add';
		header("Location: $url");
		
	}
	else{
		$sql = "UPDATE `tbl_add_bill` SET `bill_type`='".$_POST['ddlBillType']."',`bill_date`='".$_POST['txtBillDate']."',`bill_month`='".$_POST['ddlBillMonth']."',`bill_year`='".$_POST['ddlBillYear']."',`total_amount`='".$_POST['txtTotalAmount']."',`deposit_bank_name`='".$_POST['txtDepositBankName']."',`bill_details`='".$_POST['txtBillDetails']."' WHERE bill_id='".$_GET['id']."'";
		mysql_query($sql,$link);
		//mysql_close($link);
		$url = WEB_URL . 'bill/bill_list.php?m=up';
		header("Location: $url");
	}

	$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysql_query("SELECT * FROM tbl_add_bill where bill_id = '" . $_GET['id'] . "'",$link);
	while($row = mysql_fetch_array($result)){
		$bill_type = $row['bill_type'];
		$bill_date = $row['bill_date'];
		$bill_month = $row['bill_month'];
		$bill_year = $row['bill_year'];
		$total_amount = $row['total_amount'];
		$deposit_bank_name = $row['deposit_bank_name'];
		$bill_details = $row['bill_details'];
		$hdnid = $_GET['id'];
		$title = $_data['text_1_1'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['text_16'];
		$form_url = WEB_URL . "bill/add_bill.php?id=".$_GET['id'];
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
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>bill/bill_list.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_4'];?></h3>
      </div>
      
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#ddlBillType").val() == ''){
		alert("Bill Type Required !!!");
		$("#ddlBillType").focus();
		return false;
	}
	else if($("#txtBillDate").val() == ''){
		alert("Date is Required !!!");
		$("#txtBillDate").focus();
		return false;
	}
	else if($("#ddlBillMonth").val() == ''){
		alert("Bill Month is Required !!!");
		$("#ddlBillMonth").focus();
		return false;
	}
	else if($("#ddlBillYear").val() == ''){
		alert("Bill Year is Required !!!");
		$("#ddlBillYear").focus();
		return false;
	}
	else if($("#txtTotalAmount").val() == ''){
		alert("Total is Required !!!");
		$("#txtTotalAmount").focus();
		return false;
	}
	else if($("#txtDepositBankName").val() == ''){
		alert("Bank Name is Required !!!");
		$("#txtDepositBankName").focus();
		return false;
	}
	else if($("#txtBillDetails").val() == ''){
		alert("Bill Details Required !!!");
		$("#txtBillDetails").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
