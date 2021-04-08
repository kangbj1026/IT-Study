<?php
session_start(); // 세션의 시작
session_unset(); // 모든 세션변수를 언제리스터 시켜줌
session_destroy(); // 세션해제함

if (!isset($_SESSION['ss_mb_id'])) {
    echo " <script> alert('로그아웃 되었습니다.');</script> ";
    echo " <script>location.replace('../view/login.php');</script>";
    exit;
}
?>