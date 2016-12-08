<?php
require_once 'phpass-0.3/PasswordHash.php';

if(session_status() !== PHP_SESSION_ACTIVE) { @session_start(); }

$width = 170;
$height = 50;
$font_size = 16;
$font = 'font/arnamu_mono.ttf';

$letters = array("к", "о", "к", "о", "с", "м", "я", "т", "а", "б", "л", "д", "ж", "а", "д", "е", "ф", "г", "л", "е", "н", "н", "и", "ы", "ф", "х", "т", "а", "г", "н");

$src = imagecreatetruecolor($width,$height);
$fon = imagecolorallocate($src, 0, 0, 0);
imagefill($src, 0, 0, $fon);

$cocosFactor = rand(1,10);
$amount = rand(2,7);
$startpos = rand(0, $amount-5);
$cocosIterator = 0;
$shiftX = abs(($width - $amount*$font_size*1.7)/2);

# CAPTCHA BACKGROUND RANDOM
for($i=0; $i<30; $i++) {
	$color = imagecolorallocatealpha($src, rand(80,120), rand(200,255), rand(20,80), 100); 
	$size = rand($font_size-2,$font_size+2);
	imagettftext($src, $size, rand(-45,45), rand($width*0.1,$width-$width*0.1), rand($height*0.2,$height), $color, $font, $letters[rand(0,sizeof($letters)-1)]);
}

# CAPTCHA GENERATION
for($i=0; $i<=$amount; $i++) {
	$color = imagecolorallocatealpha($src, rand(160,200), rand(200,255), rand(80,120), rand(20,40));
	if(($amount >= 4) && ($cocosFactor >= 10) && ($i >= $startpos) && ($i <= $startpos+4)) {
		$letter = $letters[$cocosIterator];
		$cocosIterator++;
	}
	else $letter = $letters[rand(0,sizeof($letters)-1)];

	$size = rand($font_size*2-2, $font_size*2+2);
	$x = $shiftX + $i*$font_size + rand(6,8);
	$y = (($height*2)/3) + rand(0,5);
	$code[] = $letter;   
	imagettftext($src, $size, rand(-15,15), $x, $y, $color, $font, $letter);
}

$t_hasher = new PasswordHash(8, FALSE);
$code = implode('', $code);
$_SESSION['captcha'] = $t_hasher->HashPassword($code);

# DEBUG
$_SESSION['cocosf'] = array($cocosFactor, ($cocosFactor>=10 ? true : false), $amount+1, $startpos, $shiftX, $amount*$font_size*2);

header("Content-type: image/gif");
imagegif($src);

?> 