<code>
<?php
	@session_start();
	echo "<hr/><h4>Капча</h4>";
	echo "Хэш капчи в сессии - '{$_SESSION['secpic']}'";
	echo "<br/>Количество букв в капче - {$_SESSION['cocosf'][2]} на (3-8) вероятных";

	echo "<hr/><h4>Детерменированный кокос</h4>";
	echo "Кокосовый фактор составил {$_SESSION['cocosf'][0]}/10 ";
	echo ($_SESSION['cocosf'][1] ? "(слово присутствует)" : "(слово отсутствует)");
	if($_SESSION['cocosf'][1])
		echo "<br/>Стартовая позиция слова 'кокос' - {$_SESSION['cocosf'][3]} на (0-".($_SESSION['cocosf'][2]-5).") вероятных";

	echo "<hr/><h4>Размеры</h4>";
	echo "Сдвиг по Х составил {$_SESSION['cocosf'][4]}px";
	echo "<br/>Ширина слова капчи - относительных {$_SESSION['cocosf'][5]}px на фиктивных 170px максимальной ширины";
?>
</code>