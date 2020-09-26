<?php

	if(isset($_GET['id']) && $_GET['id'] != ""){?>


	<?php include("db.php");
		
		$flag = false;
		foreach ($posts as $key => $value){
			if($value['id'] == $_GET['id']){

				$flag = true;
				render($value);
			}
		}

		if(!$flag){
			echo "404";
		}
	?>

	<?php
	}else{

		header("location: index.php");
	}


	function render($mass){
		echo "<article>";
		echo "<h1>".$mass['title']."</h1>";
		echo "<p>".$mass['full-content']."</p>";
		echo "</article>";
	}
	
?>


