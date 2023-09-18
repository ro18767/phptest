<?php

$uri = $_SERVER[ 'REQUEST_URI' ] ;  // адреса запиту
$router = [  // масив у РНР створюється [] або array()
	'/index' => 'index.php',   // масиви - асоціативні (схожі на об'єкти JS)
	'/'      => 'index.php',
	'/about' => 'about.php',
	'/forms' => 'forms controler.php',
] ;
$router[ '/db' ] = 'db.php' ;  // доповнення масиву новим елементом
if( isset( $router[$uri] ) ) {
	if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {  // робота з формами
		include $router[$uri] ;  // без шаблону - на файл
	}
	else {	
		$page =  // змінні локалізуються тільки у функціях, оголошена поза функцією змінна доступна скрізь, у т.ч. в іншому файлі
			$router[$uri] ;  // у РНР оператор "+" діє тільки на числа, для рядків - оператор "."
		include '_layout.php' ;  // перехід до інструкцій в іншому файлі
	}
}
else {
	echo 'access manager - 404' ;
}
