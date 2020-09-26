<?php  
	session_start();	
function sum($a,$b){
	$a = (int)$a;
	$b = (int)$b;
	return $a+$b;
}
function sub($a,$b){
	$a = (int)$a;
	$b = (int)$b;
	return $a-$b;
}
function del($a,$b){
	$a = (int)$a;
	$b = (int)$b;
	return $a/$b;
}
function multi($a,$b){
	$a = (int)$a;
	$b = (int)$b;
	return $a*$b;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<?php
	if(isset($_POST['c1']) && isset($_POST['c2']) && isset($_POST['action']) && !empty($_POST['c1']) && !empty($_POST['c2']) && !empty($_POST['action'])){
	switch ($_POST['action']){
		case '+':
			$rez = sum($_POST['c1'], $_POST['c2']);
			$_SESSION['history'][] = $rez;
			break;
		case '-':	
			$rez = sub($_POST['c1'], $_POST['c2']);
			$_SESSION['history'][] = $rez;
			break;
		case '/':
			if($_POST['c2'] !=0){
				$rez = del($_POST['c1'],$_POST['c2']);
				$_SESSION['history'][] = $rez;
				}
			else
				echo "Делить на ноль нельзя";
			break;
		case "*":			
			$rez = multi($_POST['c1'],$_POST['c2']);
			$_SESSION['history'][] = $rez;
			break;
		default:
			echo "Операция не введена или неверная";
			break;
	}
	
}
?>
	<form action="index.php" method="post">
		<textarea name="history" cols="75" rows="4"><?php foreach($_SESSION['history'] as $value){
			echo $value."\n";
		} ?></textarea>
		<br>
		<input type="text" name='c1' placeholder="Первое число">
		<input type="text" name='action' placeholder="Выбор операции">
		<input type="text" name='c2' placeholder="Второе число">
		<input type="submit" value="=">
	</form>
<?php

?>
</body>
</html>