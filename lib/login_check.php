<?php
require_once "./dbconn.php";  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
// trim : 문자열의 시작과 끝에는 공백을 제거
$mb_id			= trim($_POST['mb_id']);
$mb_password	= trim($_POST['mb_password']);

if (!$mb_id || !$mb_password) {
	echo "<script>alert('회원아이디나 비밀번호가 공백이면 안됩니다.');</script>";
	echo "<script>location.replace('../view/login.php');</script>";
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
	echo "<script>location.replace('../view/login.php');</script>";
	exit;
}

if ($mb['mb_email_certify'] == '0000-00-00 00:00:00') { // 메일 인증 확인
	include_once('./function.php'); // 메일 전송을 위한 파일을 인클루드합니다.

	$mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand())); // 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용

	$sql = " UPDATE member SET mb_email_certify2 = '$mb_md5' WHERE mb_id = '$mb_id' "; // 로그인을 시도하는 아이디가 메일 인증을 해야한다면 일회용 난수를 업데이트
	$result = mysqli_query($conn, $sql);
	mysqli_close($conn); // 데이터베이스 접속 종료

	$certify_href = 'http://localhost/myapp/lib/email_certify.php?&amp;mb_id=' . $mb_id . '&amp;mb_md5=' . $mb_md5; // 메일 인증 주소

	$subject = '인증확인 메일입니다.'; // 메일 제목

	ob_start();
	include_once('./register_update_mail.php');
	$content = ob_get_contents(); // 메일 내용
	ob_end_clean();

	$mail_from = "jungdo585@naver.com"; // 보내는 메일 주소
	$mail_to = $mb['mb_email']; // 받을 메일 주소

	mailer('관리자', $mail_from, $mail_to, $subject, $content); // 메일 전송

	echo " <script> alert('".$mb['mb_email']." 메일로 인증메일을 전송하였습니다.\\n".$mb['mb_email']." 메일로 메인인증을 받으셔야 로그인 가능합니다.'); </script>";
	echo "<script>location.replace('../view/login.php');</script>";
	exit;
}

$_SESSION['ss_mb_id'] = $mb_id; // 아이디/비밀번호 확인 후 세션 생성

mysqli_close($conn); // 데이터베이스 접속 종료

if (isset($_SESSION['ss_mb_id'])) { // 세션이 있다면 로그인 확인 페이지로 이동
	echo "<script>alert('로그인 되었습니다.');</script>";
	echo "<script>location.replace('../view/login.php');</script>";
}
?>