<?php
include("../lib/dbconn.php");  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.
?>
<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<title> Login </title>
</head>

<body>
	<div class="page_container">
		<?php if (!isset($_SESSION['ss_mb_id'])) { // 로그인 세션이 있을 경우 로그인 화면 
		?>
			<div class="login_form">

				<div class="login_form_inside">
					<h1> LOGIN </h1>
					<div class="login_input_container">

						<form action="../lib/login_admin_check.php" method="post">
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
							</div>
						</form>
					</div>
				</div>
			</div>
	</div>

<?php } else { // 로그인 세션이 없을 경우 로그인 완료 화면 
?>
	<div class="admin_form">
		<div class="admin_form_inside">
			<h1> Member List </h1>
			<div class="admin_input_container">
				<?php
				$mb_id = $_SESSION['ss_mb_id'];

				$sql = " SELECT COUNT(*) AS `cnt` FROM member "; // member 테이블에 등록되어있는 회원의 수를 구함
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				$total_count = $row['cnt'];

				$page_rows = 9;
				$page = $_GET['page'];

				$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
				if ($page < 1) {
					$page = 1;
				} // 페이지가 없으면 첫 페이지 (1 페이지)
				$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

				$list = array(); // 회원 정보를 담을 배열 선언

				$sql = " SELECT * FROM member ORDER BY mb_datetime asc LIMIT {$from_record}, {$page_rows} "; // 회원 정보를 조회
				$result = mysqli_query($conn, $sql);
				for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
					$list[$i] = $row;
					$list_num = $total_count - ($page - 1) * $page_rows; // 회원 순번
					$list[$i]['num'] = $list_num - $i;
				}

				$str = ''; // 페이징 시작
				if ($page > 1) {
					$str .= '<a href="./login_admin.php?page=1" class="pg_page pg_start"> First </a>';
				}

				$start_page = (((int)(($page - 1) / $page_rows)) * $page_rows) + 1;
				$end_page = $start_page + $page_rows - 1;

				if ($end_page >= $total_page) $end_page = $total_page;

				if ($start_page > 1) $str .= '<a href="./login_admin.php?page=' . ($start_page - 1) . '" class="pg_page pg_prev">Back' . $start_page - 1 . '</a>';

				if ($total_page > 1) {
					for ($k = $start_page; $k <= $end_page; $k++) {
						if ($page != $k)
							$str .= '<a href="./login_admin.php?page=' . $k . '" class="pg_page">' . $k . '</a>';
						else
							$str .= '<strong class="pg_current">' . $k . '</strong>';
					}
				}

				if ($total_page > $end_page) $str .= '<a href="./login_admin.php?page=' . ($end_page + 1) . '" class="pg_page pg_next">' . $end_page + 1 . 'Next</a>';

				if ($page < $total_page) {
					$str .= '<a href="./login_admin.php?page=' . $total_page . '" class="pg_page pg_end"> Last </a>';
				}

				if ($str) // 페이지가 있다면 생성
					$write_page = "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
				else
					$write_page = "";

				mysqli_close($conn); // 데이터베이스 접속 종료
				?>

				<div class="btn_wrap">
					<a href="./memo.php?kind=&page=" onclick="win_memo(this.href); return false;"> 쪽지함 </a>
					<a href="../lib/admin_logout.php"> 로그아웃 </a>
				</div>
				<br>
				<caption>Total <?php echo number_format($total_count) ?>명 <?php echo $page ?> 페이지</caption>

				<table>
					<thead>
						<tr>
							<th> 번호 </th>
							<th> 아이디 </th>
							<th> 이름 </th>
							<th> 이메일 </th>
							<th> 성별 </th>
							<th> 직업 </th>
							<th> 관심언어 </th>
							<th> 가입일 </th>
							<th> 쪽지보내기 </th>
						</tr>
					</thead>
					<?php
					for ($i = 0; $i < count($list); $i++) {
					?>
						<tbody>
							<td class="member_info"><?php echo $list[$i]['num'] ?></td>
							<td class="member_info"><?php echo $list[$i]['mb_id'] ?></td>
							<td class="member_info"><?php echo $list[$i]['mb_name'] ?></td>
							<td class="member_info"><?php echo $list[$i]['mb_email'] ?></td>
							<td class="member_info"><?php echo $list[$i]['mb_gender'] ?></td>
							<td class="member_info"><?php echo $list[$i]['mb_job'] ?></td>
							<td class="member_info"><?php echo $list[$i]['mb_language'] ?></td>
							<td class="member_info"><?php echo $list[$i]['mb_datetime'] ?></td>
							<td class="member_info"><a href="./memo_form.php?me_recv_mb_id=<?php echo $list[$i]['mb_id'] ?>" class="td_btn" onclick="win_memo(this.href); return false;">쪽지보내기</a></td>
						<?php } ?>
						<?php if (count($list) == 0) {
							echo '<tr><td colspan="9"> 등록된 회원이 없습니다. </td></tr>';
						} ?>
						</tbody>
				</table>
				<?php echo $write_page; ?>
			</div>
		</div>

		<script>
			var win_memo = function(href) { // 쪽지 팝업창
				var new_win = window.open(href, 'win_memo', 'left=100,top=100,width=620,height=600,scrollbars=1');
				new_win.focus();
			}
		</script>
	<?php } ?>
</body>

</html>