<?php
	@session_start();
	require_once 'phpass-0.3/PasswordHash.php';

	if(isset($_POST['captcha_submit'])) {
		//здесь лучше экранировать строку на случай инъекций
		//$in = SQL::escape($_POST['captcha_code']);
		$in = mb_strtolower($_POST['captcha_code'], 'UTF-8');
		$t_hasher = new PasswordHash(8, FALSE);
		if($t_hasher->CheckPassword($in, $_SESSION['captcha'])) echo "<code>Captcha OK</code>";
		else echo "<code>Capctcha fail ($in)</code>";
		unset($_POST['captcha_submit']);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Coconut Ø Captcha</title>
	<meta charset="utf-8" />
	<meta name="author" content="anonymous" />
	<meta name="description" content="Coconut Ø Captcha" />
	<style type="text/css">
		body {
			margin:0; padding:20px;
			font-size: 10pt;
			font-family: monospace;
			vertical-align: top;
		}
		#captchaIMG {
			display: inline-block;
			height: 50px; width: 170px;
			background-color: #1b1c1d; color:#eee;
			text-align: center;
			vertical-align: middle;
			line-height: 45px;
			border: none;
			cursor:pointer;
		}
		form { display: flex; }
		input[type="text"] {
			width: 170px; height: 50px;
			background-color: #ddd;
			line-height: 50px;
			text-align: center;
			font-size: 14pt;
			outline: none;
			border: none;
		}
		input[type="submit"] {
			color: #eee; background-color: #333;
			padding: 0 15px;
			line-height: 50px;
			border: none;
			outline: none;
			cursor: pointer;
		}
	</style>
</head>
<body>

	<section>
		<form id="captchaform" action="" method="post" enctype="multipart/form-data">
			<img id="captchaIMG" src="cgen.php" alt="[капча протухла]" onclick="this.src='cgen.php';" />
			<input type="hidden" name="captcha_cocosf" value="<?=$_SESSION['cocosf'][0]?>" />
			<input type="text" name="captcha_code" autocomplete="off" autofocus />
			<input type="submit" name="captcha_submit" value="Продолжить" />
		</form>
	</section>

	<script type="text/javascript">
		window.onload = setInterval(function(){ document.getElementById('captchaIMG').src = ''; }, 60000);
	</script>

</body>
</html>