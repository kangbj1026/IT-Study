<?php
require_once "dbconn.php";  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
// trim : 문자열의 시작과 끝에는 공백을 제거
$mb_id			= trim($_POST['mb_id']);
$mb_password	= trim($_POST['mb_password']);

if (!$mb_id || !$mb_password) {
	echo "<script>alert('회원아이디나 비밀번호가 공백이면 안됩니다.');</script>";
	echo "<script>location.replace('../view/login_admin.php');</script>";
	exit;
}

$sql = " SELECT * FROM member WHERE mb_id = '$mb_id' "; // 회원 테이블에서 해당 아이디가 존재하는지 체크
// mysqli_query : 데이터베이스 쿼리를 실행
$result = mysqli_query($conn, $sql);
// mysqli_fetch_assoc : 결과 행을 배열로 나열
$mb = mysqli_fetch_assoc($result);

$sql = " SELECT PASSWORD('$mb_password') AS pass "; // 입력한 비밀번호를 MySQL password() 함수를 이용해 암호화해서 가져옴
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$password = $row['pass'];

if (!$mb['mb_id'] || !($password === $mb['mb_password'])) { // 존재하는 아이디인지, 입력한 패스워드가 회원 테이블에 저장된 패스워드와 동일한지 체크
	echo "<script>alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다.');</script>";
	echo "<script>location.replace('../view/login_admin.php');</script>";
	exit;
}

$_SESSION['ss_mb_id'] = $mb_id; // 아이디/비밀번호 확인 후 세션 생성

mysqli_close($conn); // 데이터베이스 접속 종료

if (isset($_SESSION['ss_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
	echo "<script>alert('로그인 되었습니다.');</script>";
	echo "<script>location.replace('../view/login_admin.php?page=1');</script>";
}
?>