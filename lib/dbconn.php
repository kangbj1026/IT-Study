<?php
	$mysql_host = "localhost";
	$mysql_user = "root";
	$mysql_password = "1234";
	$mysql_db = "project";

	$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);
	$sql = "ALTER TABLE member AUTO_INCREMENT=1";
	$query = mysqli_query($conn, $sql);
	$sql1 = "SET @COUNT = 0";
	$query1 = mysqli_query($conn, $sql1);
	$sql2 = "UPDATE member SET mb_no = @COUNT:=@COUNT+1";
	$quert2 = mysqli_query($conn, $sql2);
	if (!$conn) {
		die("연결 실패 : " . mysqli_connect_errno());
	}
    session_start(); // 데이터베이스가 정상으로 연결이 되었다면 세션을 시작
	// http의 특성상 연결을 게속 유지 불가능, 로그인을 장바구니와 같은 기능들을 위해서 사용되는것
?>