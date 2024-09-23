<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset='utf-8'>
</head>
<body>
	<?php

		switch ($mes) {
			case 'Jan':
				$mes = 'Enero';
				break;
			case 'Feb':
				$mes = 'Febrero';
				break;
			case 'Mar':
			$mes = 'Marzo';
			break;
			case 'Apr':
				$mes = 'Abril';
				break;
			case 'May':
				$mes = 'Mayo';
				break;	
			case 'Jun':
				$mes = 'Junio';
				break;
			case 'Jul':
				$mes = 'Julio';
				break;
			case 'Aug':
				$mes = 'Agosto';
				break;
			case 'Sep':
				$mes = 'Septiembre';
				break;
			case 'Oct':
				$mes = 'Octubre';
				break;
			case 'Nov':
				$mes = 'Noviembre';
				break;
			case 'December':
				$mes = 'Diciembre';
				break;				
			default:
				$mes = '______________';
				break;
		}

?>
</body>
</html>
