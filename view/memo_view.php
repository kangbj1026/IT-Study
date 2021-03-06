<?php
require_once "../lib/dbconn.php";  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

$mb_id = $_SESSION['ss_mb_id'];
$kind = $_GET['kind'] ? $_GET['kind'] : 'recv';

if (!$mb_id) {
	echo "<script>alert('회원만 이용하실 수 있습니다.');window.close();</script>";
	exit;
}

$me_id = $_GET['me_id'];
$me_read_datetime	= date('Y-m-d H:i:s', time()); // 메모읽은일시

$sql = " SELECT * FROM memo
			WHERE me_id = '$me_id'
			AND me_{$kind}_mb_id = '$mb_id' ";
$result = mysqli_query($conn, $sql);
$memo = mysqli_fetch_assoc($result);

if ($kind == 'recv') {
	$unkind = 'send';
	$memo_id = $memo['me_send_mb_id'];
	$kind_str = "보낸";
	$kind_date = "받은";

	$sql = " UPDATE memo
				SET me_read_datetime = '$me_read_datetime'
				WHERE me_id = '$me_id'
				AND me_recv_mb_id = '$mb_id'
				AND me_read_datetime = '0000-00-00 00:00:00' ";
	$result = mysqli_query($conn, $sql);
} else if ($kind == 'send') {
	$unkind = 'recv';
	$memo_id = $memo['me_recv_mb_id'];
	$kind_str = "받는";
	$kind_date = "보낸";
} else {
	echo "<script>alert('변수 kind 값이 없습니다.');window.close();</script>";
	exit;
}

// $list = array();

// $sql = " SELECT a.*, b.mb_id, b.mb_name, b.mb_email
// 			FROM memo a
// 			LEFT JOIN member b ON (a.me_{$unkind}_mb_id = b.mb_id)
// 			WHERE a.me_{$kind}_mb_id = '{$mb_id}'
// 			ORDER BY a.me_id";
// $result = mysqli_query($conn, $sql);
// for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
// 	$list[$i] = $row;

// 	$mb_id = $row["me_{$unkind}_mb_id"];
// }

mysqli_close($conn); // 데이터베이스 접속 종료
?>

<html>

<head>
	<title>Memo View</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body class="memo_form">
	<div class="page_container">

		<!-- 쪽지 보기 시작 { -->
		<div class="memo_form_inside">
			<h1>쪽지 보기</h1>
			<div class="memo_input_container">

				<ul>
					<li><a href="./memo.php?kind=recv&page=">받은쪽지</a></li>
					<li><a href="./memo.php?kind=send&page=">보낸쪽지</a></li>
					<li><a href="./memo_form.php?me_recv_mb_id=">쪽지쓰기</a></li>
				</ul>

				<article>
					<header>
						<h1>쪽지 내용</h1>
					</header>
					<table>
						<colgroup>
							<col width="20%">
							<col width="*">
							<col width="20%">
							<col width="*">
						</colgroup>
						<tr>
							<th><?php echo $kind_str ?>사람</th>
							<td><strong><?php echo $memo_id ?></strong></td>
							<th><?php echo $kind_date ?>시간</th>
							<td><strong><?php echo $memo['me_send_datetime'] ?></strong></td>
						</tr>
						<tr>
							<td colspan="4"><?php echo nl2br($memo['me_memo']) ?></td>
						</tr>
					</table>
				</article>

				<div class="btn_wrap">
					<?php if ($kind == 'recv') {  ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $memo['me_send_mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>"> 답장 </a><?php } ?>
					<a href="./memo.php?kind=<?php echo $kind ?>&page="> 목록보기 </a>
					<button type="button" onclick="window.close();"> 창닫기 </button>
				</div>
			</div>
		</div>
	</div>
	<!-- } 쪽지보기 끝 -->
</body>

</html>