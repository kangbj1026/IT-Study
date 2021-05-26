<?php require_once "../lib/dbconn.php";  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
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
	<title> modify </title>
</head>
<body>
<div id="main">
<a href="../community/main.php" class="main"> main </a>
<?php 
if (@$_SESSION['ss_mb_id']) { ?>
<a href="../view/login.php" class="login"> <?php echo $_SESSION['ss_mb_id'] ?> 회원님 </a>	
<?php } else {?>
<a href="../view/login.php" class="login"> login </a>
<?php }?>
</div>
<div class="page_container">
		<div class="modify">
			<div class="modify_form">
			<form action="../lib/board_update.php" method="POST">
			<h1> Modify </h1>
				<table class="modify_table">
					<thead>
						<tr>
							<th> 제목 </th>
							<th> 내용 </th>
							<th> </th>
						</tr>
					</thead>
					<tbody>
                    <?php while ($mb = mysqli_fetch_array($result)) { ?>
						<tr>
							<input type="hidden" name="board_no" value="<?php echo $mb['board_no'] ?>">
							<th> <input type="text" name="subject" class="subject" value="<?php echo $mb['subject']?>"> </th>
							<th colspan="3"> <textarea name="contents" class="contents"><?php echo $mb['contents']?></textarea> </th>
						</tr>
					</tbody>
				</table>
				<input type="submit" name="submit" class="submit_btn" value="수정완료">
				<input type="button" class="reload_btn" onclick="document.location.reload();" value="새로고침">
				<input type="button" class="back_btn" onclick="window.history.back()" value="취소">
                <?php } mysqli_close($conn); ?>
			</form>
			</div>
		</div>
	</div>
</body>
</html>