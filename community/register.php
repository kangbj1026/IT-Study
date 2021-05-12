<?php
include("../lib/dbconn.php");  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

$sql = " select * from member ";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);
if (isset($_SESSION['ss_mb_id']) && $_GET['mode'] == 'modify') { // 세션이 있고 회원수정 mode라면 회원 정보를 가져옴
	$mb_id = $_SESSION['ss_mb_id'];

	$sql = " SELECT * FROM member WHERE mb_id = '$mb_id' "; // 회원 정보를 조회
	$result = mysqli_query($conn, $sql);
	$mb = mysqli_fetch_assoc($result);
	mysqli_close($conn); // 데이터베이스 접속 종료

	$mode = "modify";
	$title = "회원수정";
	$modify_mb_info = "readonly";
} else {
	$mode = "insert";
	$title = "회원가입";
	$modify_mb_info = '';
	$mb['mb_id'] = $mb['space'];
	$mb['mb_name'] = $mb['space'];
	$mb['mb_email'] = $mb['space'];
	$mb['mb_job'] = $mb['space'];
	$mb['mb_gender'] = $mb['space'];
	$mb['mb_language'] = $mb['space'];
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="vieport" content="width=device-width, initial-scale=1.0">
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<title> Register </title>
</head>
<div id="main">
<a href="../community/main.php" class="main"> main </a>
<a href="../view/login.php" class="login"> login </a>
</div>
<body>
	<div class="page_container">
		<div class="member_form">
			<div class="member_form_inside">
				<h1><?php echo $title ?></h1>

				<div class="member_input_container">
					<form action="../lib/register_update.php" onsubmit="return fregisterform_submit(this);" method="post">
						<input type="hidden" name="mode" value="<?php echo $mode ?>">


						<div class="member">
							<span class="member_info">아이디</span>
							<span class="member_update"><input class="input_text" type="text" name="mb_id" value="<?php echo $mb['mb_id'] ?>" <?php echo $modify_mb_info ?>></span>
						</div>
						<div class="member">
							<span class="member_info">비밀번호</span>
							<span class="member_update"><input class="input_text" type="password" name="mb_password"></span>
						</div>
						<div class="member">
							<span class="member_info">비밀번호 확인</span>
							<span class="member_update"><input class="input_text" type="password" name="mb_password_re"></span>
						</div>
						<div class="member">
							<span class="member_info">이름</span>
							<span class="member_update"><input class="input_text" type="text" name="mb_name" value="<?php echo $mb['mb_name'] ?>" <?php echo $modify_mb_info ?>></span>
						</div>
						<div class="member">
							<span class="member_info">이메일</span>
							<span class="member_update"><input class="input_text" type="text" name="mb_email" value="<?= $mb['mb_email']; ?>"></span>
						</div>
						<div class="member">
							<span class="member_info">성별</span>
							<span>
								<label><input type="radio" name="mb_gender" value="남자" <?php echo ($mb['mb_gender'] == "남자") ? "checked" : ""; ?>>남자</label><span></span>
								<label><input type="radio" name="mb_gender" value="여자" <?php echo ($mb['mb_gender'] == "여자") ? "checked" : ""; ?>>여자</label>
							</span>
						</div>
						<div class="member">
							<span class="member_info">직업</span>
							<span>
								<select name="mb_job">
									<option value="">선택하세요</option>
									<option value="학생" <?php echo ($mb['mb_job'] == "학생") ? "selected" : ""; ?>>학생</option>
									<option value="회사원" <?php echo ($mb['mb_job'] == "회사원") ? "selected" : ""; ?>>회사원</option>
									<option value="공무원" <?php echo ($mb['mb_job'] == "공무원") ? "selected" : ""; ?>>공무원</option>
									<option value="주부" <?php echo ($mb['mb_job'] == "주부") ? "selected" : ""; ?>>주부</option>
									<option value="무직" <?php echo ($mb['mb_job'] == "무직") ? "selected" : ""; ?>>무직</option>
								</select>
							</span>
						</div>
						<div class="member">
							<span class="member_info">관심언어</span>
							<span>
								<label><input type="checkbox" name="mb_language[]" value="HTML" <?php echo strpos($mb['mb_language'], 'HTML') !== false ? 'checked' : '' ?>> HTML </label>
								<label><input type="checkbox" name="mb_language[]" value="CSS" <?php echo strpos($mb['mb_language'], 'CSS') !== false ? 'checked' : '' ?>> CSS </label> <br>
								<label><input type="checkbox" name="mb_language[]" value="PHP" <?php echo strpos($mb['mb_language'], 'PHP') !== false ? 'checked' : '' ?>> PHP </label>						
								<label><input type="checkbox" name="mb_language[]" value="MySQL" <?php echo strpos($mb['mb_language'], 'MySQL') !== false ? 'checked' : '' ?>> MySQL </label>
								<label><input type="hidden" name="mb_language[]" value=""> </label>
							</span>
						</div>
						<div class="btn_wrap">
							<input class="btn_click" type="submit" value="<?php echo $title ?>"> <a href="./login.php">취소</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
	
		function fregisterform_submit(f) { // submit 최종 폼체크
			if (f.mb_id.value.length < 1) { // 회원아이디 검사
				alert("아이디를 입력하십시오.");
				f.mb_id.focus();
				return false;
			}

			if (f.mb_name.value.length < 1) { // 이름 검사
				alert("이름을 입력하십시오.");
				f.mb_name.focus();
				return false;
			}

			if (f.mb_password.value.length < 3) {
				alert("비밀번호를 3글자 이상 입력하십시오.");
				f.mb_password.focus();
				return false;
			}

			if (f.mb_password.value != f.mb_password_re.value) {
				alert("비밀번호가 같지 않습니다.");
				f.mb_password_re.focus();
				return false;
			}

			if (f.mb_password.value.length > 0) {
				if (f.mb_password_re.value.length < 3) {
					alert("비밀번호를 3글자 이상 입력하십시오.");
					f.mb_password_re.focus();
					return false;
				}
			}

			if (f.mb_email.value.length < 1) { // 이메일 검사
				alert("이메일을 입력하십시오.");
				f.mb_email.focus();
				return false;
			}

			if (f.mb_email.value.length > 0) { // 이메일 형식 검사
				var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
				if (f.mb_email.value.match(regExp) == null) {
					alert('이메일 주소가 형식에 맞지 않습니다.');
					f.mb_email.focus();
					return false;
				}
			}

			if (f.mb_gender.value == "") { // 성별 검사
				alert("성별을 선택하시지 않았습니다.");
				return false;
			}

			if (f.mb_job.value == "") { // 직업 검사
				alert("직업을 선택하시지 않았습니다.");
				return false;
			}
			return true;
		}
	</script>
</body>

</html>