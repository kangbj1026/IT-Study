<?php
require_once "./dbconn.php";
$board_no = trim($_GET['board_no']);
$member_id = $_SESSION['ss_mb_id'];

$sql = " DELETE FROM board
            WHERE member_id = '{$member_id}'
            AND (board_no = '$board_no')";

$result = mysqli_query($conn, $sql);

if ($result) {
	$url = '../community/main.php';
	echo "<script>alert('삭제 완료 되었습니다.');location.replace('$url');</script>";
	exit;
} else {
	echo "삭제 실패: " . mysqli_error($conn);
	mysqli_close($conn);
}
?>