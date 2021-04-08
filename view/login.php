<?php
include("../lib/dbconn.php");  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<title> Login </title>
</head>
<body>
	<div class="page_container">
		<div class="login_form">
			<?php if (!isset($_SESSION['ss_mb_id'])) { // 로그인 세션이 있을 경우 로그인 화면 
			?>
				<div class="login_form_inside">
					<h1> LOGIN </h1>
					<div class="login_input_container">

						<form action="../lib/login_check.php" method="post">
							<div class="login_input_wrap">
								<span> ID </span>
								<input type="text" name="mb_id">
							</div>
							<div class="login_input_wrap">
								<span> PW </span>
								<input type="password" name="mb_password">
							</div>

							<div class="btn_wrap">
								<input class="btn_click" type="submit" value="로그인">
								<a href="./register.php">회원가입</a>
							</div>
						</form>
					</div>
				</div>
		</div>
	</div>

<?php } else { // 로그인 세션이 없을 경우 로그인 완료 화면 
?>
	<div class="member_form_inside">
		<h1>로그인을 환영합니다.</h1>
		<div class="member_input_container">
			<?php
				$mb_id = $_SESSION['ss_mb_id'];

				$sql = " select * from member where mb_id = TRIM('$mb_id') ";
				$result = mysqli_query($conn, $sql);
				$mb = mysqli_fetch_assoc($result);

				mysqli_close($conn); // 데이터베이스 접속 종료
			?>
			<div class="member">
				<span class="member_info">아이디</span>
				<span class="member_info"><?php echo $mb['mb_id'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 이름 </span>
				<span class="member_info"><?php echo $mb['mb_name'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 이메일 </span>
				<span class="member_info"><?php echo $mb['mb_email'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 성별 </span>
				<span class="member_info"><?php echo $mb['mb_gender'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 직업 </span>
				<span class="member_info"><?php echo $mb['mb_job'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 관심언어 </span>
				<span class="member_info"><?php echo $mb['mb_language'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 이메일인증일 </span>
				<span class="member_info"><?php echo $mb['mb_email_certify'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 회원가입일 </span>
				<span class="member_info"><?php echo $mb['mb_datetime'] ?></span>
			</div>
			<div class="member">
				<span class="member_info"> 회원정보 수정일 </span>
				<span class="member_info"><?php echo $mb['mb_modify_datetime'] ?></span>
			</div>
			<div class="btn_wrap">
				<a class="btn_click" href="./register.php?mode=modify">회원정보수정</a>
				<a href="../lib/logout.php">로그아웃</a>
			</div>
		</div>
	</div>
	</div>
	</div>
<?php } ?>
</body>

</html>