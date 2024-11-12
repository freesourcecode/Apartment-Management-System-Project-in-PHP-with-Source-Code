<?php 
include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_owner.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$o_name = '';
$o_email = '';
$o_contact = '';
$o_pre_address = '';
$o_per_address = '';
$o_nid = '';
$o_password = '';
$owner_unit = '';
$branch_id = '';
$title = $_data['add_new_owner'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_owner_successfully'];
$form_url = WEB_URL . "owner/addowner.php";
$id="";
$hdnid="0";
$image_own = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$rowx_unit = array();

if(isset($_POST['txtOwnerName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	$o_password = $_POST['txtPassword'];
	$image_url = uploadImage();
	$sql = "INSERT INTO tbl_add_owner(o_name,o_email, o_contact, o_pre_address,o_per_address,o_nid,o_password,image,branch_id) values('$_POST[txtOwnerName]','$_POST[txtOwnerEmail]','$_POST[txtOwnerContact]','$_POST[txtOwnerPreAddress]','$_POST[txtOwnerPerAddress]','$_POST[txtOwnerNID]','$o_password','$image_url','" . $_SESSION['objLogin']['branch_id'] . "')";
	mysql_query($sql,$link);
	 $last_id = mysql_insert_id();
	  if(isset($_POST['ChkOwnerUnit'])){   /*if open */
		foreach ($_POST['ChkOwnerUnit'] as $value) {   /*foreach open */
			$sql_unit="INSERT INTO `tbl_add_owner_unit_relation`(owner_id,unit_id) VALUES($last_id,$value)";
			mysql_query($sql_unit,$link);	 
		}  /* foreach close */
	  }  /* if close */
	  else {
			echo "No results";  
	  }

	mysql_close($link);
	$url = WEB_URL . 'owner/ownerlist.php?m=add';
	header("Location: $url");
	
}
else{
	$image_url = uploadImage();
	if($image_url == ''){
		$image_url = $_POST['img_exist'];
	}
	$sql = "UPDATE `tbl_add_owner` SET `o_name`='".$_POST['txtOwnerName']."',`o_email`='".$_POST['txtOwnerEmail']."',`o_password`='".$_POST['txtPassword']."',`o_contact`='".$_POST['txtOwnerContact']."',`o_pre_address`='".$_POST['txtOwnerPreAddress']."',`o_per_address`='".$_POST['txtOwnerPerAddress']."',`o_nid`='".$_POST['txtOwnerNID']."',`image`='".$image_url."' WHERE ownid='".$_GET['id']."'";
	mysql_query($sql,$link);
	if(isset($_POST['ChkOwnerUnit'])){  /* if open */
		$sql_unit= "DELETE FROM `tbl_add_owner_unit_relation` WHERE owner_id = ".$_GET['id'];
		mysql_query($sql_unit,$link);
		foreach ($_POST['ChkOwnerUnit'] as $value) {  /* foreach open */
			$sql_unit="INSERT INTO `tbl_add_owner_unit_relation`(owner_id,unit_id) VALUES('$_GET[id]',$value)";
			mysql_query($sql_unit,$link);
		}  /* foreach close */
	  } /* if close */
	  else {
			$sql_unit= "DELETE FROM `tbl_add_owner_unit_relation` WHERE owner_id = ".$_GET['id'];
			mysql_query($sql_unit,$link); 
	  }
	$url = WEB_URL . 'owner/ownerlist.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysql_query("SELECT * FROM tbl_add_owner where ownid = '" . $_GET['id'] . "'",$link);
	while($row = mysql_fetch_array($result)){
		
		$o_name = $row['o_name'];
		$o_email = $row['o_email'];
		$o_contact = $row['o_contact'];
		$o_pre_address = $row['o_pre_address'];
		$o_per_address = $row['o_per_address'];
		$o_password = $row['o_password'];
		$o_nid = $row['o_nid'];
		if($row['image'] != ''){
			$image_own = WEB_URL . 'img/upload/' . $row['image'];
			$img_track = $row['image'];
		}
		$hdnid = $_GET['id'];
		$title = 'Update Owner';
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_owner_successfully'];
		$form_url = WEB_URL . "owner/addowner.php?id=".$_GET['id'];
	}
	$result_unit = mysql_query("SELECT unit_id FROM tbl_add_owner_unit_relation where owner_id = '" . $_GET['id'] . "'",$link);
	while($row_unit = mysql_fetch_array($result_unit)){
		array_push($rowx_unit,$row_unit['unit_id']);
	}
	//mysql_close($link);

}
//for image upload
function uploadImage(){
	if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
	  $filename = basename($_FILES['uploaded_file']['name']);
	  $ext = substr($filename, strrpos($filename, '.') + 1);
	  if(($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')){   
	  	$temp = explode(".",$_FILES["uploaded_file"]["name"]);
	  	$newfilename = NewGuid() . '.' .end($temp);
		move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
		return $newfilename;
	  }
	  else{
	  	return '';
	  }
	}
	return '';
}
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
}	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $_data['add_new_owner'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>/dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_owner_information_breadcam'];?></li>
    <li class="active"><?php echo $_data['add_new_owner_breadcam'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>owner/ownerlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_owner_entry_form'];?></h3>
      </div>
     
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#txtOwnerName").val() == ''){
		alert("Owner Name Required !!!");
		$("#txtOwnerName").focus();
		return false;
	}
	else if($("#txtOwnerEmail").val() == ''){
		alert("Email Required !!!");
		$("#txtOwnerEmail").focus();
		return false;
	}
	else if($("#txtPassword").val() == ''){
		alert("Password Required !!!");
		$("#txtPassword").focus();
		return false;
	}
	else if($("#txtOwnerContact").val() == ''){
		alert("Contact Number Required !!!");
		$("#txtOwnerContact").focus();
		return false;
	}
	else if($("#txtOwnerPreAddress").val() == ''){
		alert("Present Address Required !!!");
		$("#txtOwnerPreAddress").focus();
		return false;
	}
	else if($("#txtOwnerPerAddress").val() == ''){
		alert("Permanent Address Required !!!");
		$("#txtOwnerPerAddress").focus();
		return false;
	}
	else if($("#txtOwnerNID").val() == ''){
		alert("NID Required !!!");
		$("#txtOwnerNID").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
