<?php
	include("db.php");

	$count_post_page = 6;

	$posts = sort_posts($posts);

	// $count_el - количество элементов в массиве статей
	// $n - сколько статей на странице
	function pagination($count_el, $n){
		if($count_el / $n > 1){
			echo "<ul>";
			$class = "";
			$sort = "";
			for ($i=0; $i < $count_el / $n; $i++) { 
				global $count_post_page;

				
				if(	(!isset($_GET['start']) && $i == 0) ||  
					(isset($_GET['start']) && ($i == ($_GET['start'] / $count_post_page)))){
					$class = "active";
				}

				if(isset($_GET['sort']) && $_GET['sort'] != ""){
					$sort = "&sort=".$_GET['sort'];
				}
				

				echo "<li class='".$class."'><a href='?start=".($i * $count_post_page)."".$sort."'>".($i+1)."</a></li>";

				$class = "";
			}
			echo "</ul>";
		}

	}

	// сортировка постов
	function sort_posts($mass){
		if(isset($_GET['sort']) && $_GET['sort'] != ""){

			switch ($_GET['sort']) {
				case '0':break;
				case '1': rsort($mass); break;
				case '2':break;
				case '3':break;
				default:break;
			}

			return $mass;
		}

	}

	//вывод формы сортировки
	function sort_form(){
		echo "<form method='get' action='index.php'>";
		echo "<select name='sort'>";
		echo "<option value='0' selected>Сначала новые</option>";
		echo "<option value='1' selected>Сначала старые</option>";
		echo "<option value='2' selected>Сортировать по названию (а-я)</option>";
		echo "<option value='3' selected>Сортировать по названию (я-а)</option>";
		echo "</select>";

		echo "<input type='submit' value='отсортировать'>";
		echo "</form>";
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Пагинация</title>
	<style>
		ul{
			display: flex;
			justify-content: center;
			padding:0px;
			margin:0px;
			list-style: none;
		}
		li a{
			display: block;
			padding: 5px;
			margin:0 3px;
		}
		li.active a{
			background-color: #ccc;
		}
	</style>
</head>
<body>
	


	<?php 


		if(isset($_GET['start']) && $_GET['start'] != ""){
			$start = $_GET['start'];
		}
		else{
			$start = 0;
		}

		sort_form();

		for($i = $start; ($i < count($posts)) && ($i < $count_post_page + $start); $i++){?>

		<article>
			<h2><?php echo $posts[$i]['title'];?></h2>
			<p><?php echo $posts[$i]['short-content'];?></p>
			<a href="post.php?id=<?php echo $posts[$i]['id'];?>">Подробнее</a>
		</article>
		
	<?php }?>

	<?php 
		pagination(count($posts), $count_post_page);
	?>

</body>
</html>