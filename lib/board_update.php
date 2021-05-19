<?php
require_once "./dbconn.php";
$board_no = trim($_POST['board_no']);
$subject = trim($_POST['subject']);
$contents = trim($_POST['contents']);
$reg_date = date("Y-m-d H:i:s");

if ($_POST) {
	$sql = " UPDATE board
	SET subject = '$subject',
		contents = '$contents',
		reg_date = '$reg_date'
	WHERE board_no = $board_no ";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		echo "<script>alert('수정 성공!');location.replace('../community/read.php?board_no=$board_no');</script>";
		exit;
	} else {
		echo "<script>alert('수정 실패!!');window.location.href = 'http://localhost/myStudy/community/modify.php?board_no=$board_no';</script>";
		exit;
	}
}
?>