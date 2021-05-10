<?php
include("./dbconn.php");
$member_id = $_SESSION['ss_mb_id'];
$subject = trim($_POST['subject']);
$contents = trim($_POST['contents']);
$reg_date = date("Y-m-d H:i:s");

$mode = $_POST['mode'];
if ($_POST['mode']) {
	$sql = "INSERT INTO board
		SET member_id = '$member_id',
			subject = '$subject',
			contents = '$contents',
			reg_date = '$reg_date' ";
			// print_r($sql);die;
	$result = mysqli_query($conn, $sql);
	
	if ($result) {
		echo "<script>alert('입력성공!');window.location.href = 'http://localhost/myStudy/view/main.php';</script>";
		mysqli_close($conn);
		exit;
	} else {
		echo "<script>alert('입력살패!!');window.location.href = 'http://localhost/myStudy/view/write.php';</script>";
		exit;
	}
}
?>