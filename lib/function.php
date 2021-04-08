<?php
// 메일 전송을 위한 라이브러리
include_once('./PHPMailer/PHPMailerAutoload.php');
 
// 네이버 메일 전송
// 메일 -> 환경설정 -> POP3/IMAP 설정 -> POP3/SMTP & IMAP/SMTP 중에 IMAP/SMTP 사용
 
// 메일 보내기
// mailer("보내는 사람 이름", "보내는 사람 메일주소", "받는 사람 메일주소", "제목", "내용");
function mailer($fname, $fmail, $to, $subject, $content)
{
    $mail = new PHPMailer();
    
    $mail->IsSMTP(); 

    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true; 
 
    $mail->Host = "smtp.naver.com"; 
    $mail->Port = 465; 
    $mail->Username = "jungdo585"; // 네이버메일 계정
    $mail->Password = "musiclove0276!@"; // 네이버메일 비밀번호
 
    $mail->CharSet = 'UTF-8';
    $mail->From = $fmail;
    $mail->FromName = $fname;
    $mail->Subject = $subject;
    $mail->msgHTML($content);
    $mail->addAddress($to);

    return $mail->send();
}
?>