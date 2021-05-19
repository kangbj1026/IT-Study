<?php require_once "../lib/dbconn.php";  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<title> write </title>
</head>
<body>
<div id="main">
<a href="../community/main.php" class="main"> main </a>
<a href="../view/login.php" class="login"> login </a>
</div>
<div class="page_container">
		<div class="write">
			<div class="write_form">
			<form action="../lib/board_insert.php" method="post">
			<h1> Write </h1>
				<table class="write_table">
					<thead>
						<tr>
							<th> 제목 </th>
							<th> 내용 </th>
							<th> </th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<input type="hidden" name="mode" value="<?php echo $mode ?>">
							<th> <input type="text" name="subject" class="subject"> </th>
							<th colspan="3"> <textarea name="contents" class="contents"></textarea> </th>
						</tr>
					</tbody>
				</table>
				<input type="submit" name="submit" class="submit_btn" value="전송">
				<input type="button" class="reload_btn" onclick="document.location.reload();" value="새로고침">
				<input type="button" class="back_btn" onclick="window.history.back()" value="취소">
			</form>
			</div>
		</div>
	</div>
</body>
</html>