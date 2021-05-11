<?php include("../lib/dbconn.php");  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
$board_no = trim($_GET['board_no']);
$sql = " SELECT * FROM board where board_no = '".$board_no."'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<title> read </title>
	<script>
		$(document).ready(function(){
			$(".delete_btn").click(function(){
				
			});
		})
	</script>
</head>
<body>
<div id="main">
<a href="../view/main.php" class="main"> main </a>
<a href="../view/login.php" class="login"> login </a>
</div>
<div class="page_container">
		<div class="read">
			<div class="read_form">
			<form action="../view/modify.php" method="GET">
			<h1> Read </h1>
				<table class="read_table">
					<thead>
						<tr>
							<th> 번호 </th>
							<!-- <th> 제목 </th> -->
							<th> 내용 </th>
							<th> ID </th>
							<th> 날짜 </th>
						</tr>
					</thead>
					<tbody>
						<?php while ($mb = mysqli_fetch_array($result)) { ?>
							<tr>
								<th> <?php echo $mb['board_no'] ?> </th>
								<th class="contents"> <?php echo $mb['contents'] ?> </th>
								<th> <?php echo $mb['member_id'] ?> </th>
								<th> <?php echo $mb['reg_date'] ?> </th>
							</tr>
					</tbody>
				</table>
				<?php if (@$_SESSION['ss_mb_id'] == $mb['member_id']) { ?>
				<button class="modify_btn" type="submit" name="board_no" value="<?php echo $mb['board_no'] ?>"> 수정하기 </button>
				<button class="delete_btn" type="button" name="board_no" onclick="document.location.href='../lib/board_delete.php?board_no=<?php echo $mb['board_no'] ?>'"> 삭제 </button>
				<?php } } mysqli_close($conn); ?> <!-- 데이터베이스 접속 종료 -->
			</form>
			</div>
		</div>
	</div>
</body>
</html>