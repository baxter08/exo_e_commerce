<?php

//fetch_data.php
error_reporting(0);

$bdd = new PDO("mysql:host=127.0.0.1;dbname=exo_e_commerce;charset=utf8", "root", "");

if(isset($_POST["action"]))
{
	$limit = '3';
	$page = 1;
	if(isset($_POST['page'])){
		if($_POST['page'] > 1) {
			$start = (($_POST['page'] - 1) * $limit);
			$page = $_POST['page'];
		  } else {
			$start = 0;
		  }
	}else{
		$start = 0;
	}

	$query = "SELECT * FROM article LEFT JOIN `nom` b ON a.nom = b.id  WHERE a.id
	";
	if(isset($_POST["search_text"]) && !empty($_POST["search_text"])){
		if($_POST["search_text"]!=" "){
	 		$query .= " AND description LIKE '%".$_POST["search_text"]."%'";
		}
	}
	if(isset($_GET["category"])){
		$types_filter = implode("','", $_GET["category"]);
		$query .= " AND `category` IN('".$types_filter."')";
	}

	if(isset($_GET["types"])){
		$types_filter = implode("','", $_GET["types"]);
		$query .= " AND `type` IN('".$types_filter."')";
	}

	if(isset($_GET["difficulty"])){
		$difficulty_filter = implode("','", $_GET["difficulty"]);
		$query .= "AND difficulty IN('".$difficulty_filter."')";
	}
	if(isset($_GET["check"])){
		$check_filter = implode("','", $_GET["check"]);
		$query .= " AND `check` IN('".$check_filter."')";
	}}


	$filter_query = $query . ' LIMIT '.$start.', '.$limit.'';	


	$statement = $bdd->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();

	$statement = $bdd->prepare($filter_query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();


	$output = '';
	if($total_row > 0)
	{
		foreach($result as $article)
		{
			$output .= '

			<div class="col-xl-4 col-12" style=" margin-bottom:20px;">
				<img src="build/images'. $article['images'] .'"> 
				<p>'. $article['nom'] .'</p>
		 	</div>
			';
		}
	}
	else
	{
		$output = '<h3 class="text-danger">Aucun résultat</h3>';
	}
	$output .= '
	<div style="margin-top: 15px" class="d-flex justify-content-center">
	  <ul class="pagination">';

	$totalLinks = ceil($total/$limit);
	$previousLink = '';
	$nextLink = '';
	$pageLink = '';	

	if($totalLinks > 4){
	  if($page < 5){
		for($count = 1; $count <= 5; $count++){
		  $pageData[] = $count;
		}
		$pageData[] = '...';
		$pageData[] = $totalLinks;
	  } else {
		$endLimit = $totalLinks - 5;
		if($page > $endLimit){
		  $pageData[] = 1;
		  $pageData[] = '...';
		  for($count = $endLimit; $count <= $totalLinks; $count++)
		  {
			$pageData[] = $count;
		  }
		} else {
		  $pageData[] = 1;
		  $pageData[] = '...';
		  for($count = $page - 1; $count <= $page + 1; $count++)
		  {
			$pageData[] = $count;
		  }
		  $pageData[] = '...';
		  $pageData[] = $totalLinks;
		}
	  }
	} else {
	  for($count = 1; $count <= $totalLinks; $count++) {
		$pageData[] = $count;
	  }
	}

	for($count = 0; $count < count($pageData); $count++){
	  if($page == $pageData[$count]){
		$pageLink .= '
		<li class="page-item active">
		  <a class="page-link" href="#">'.$pageData[$count].'</a>
		</li>';

		$previousData = $pageData[$count] - 1;
		if($previousData > 0){
		  $previousLink = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previousData.'">Previous</a></li>';
		} else {
		  $previousLink = '
		  <li class="page-item disabled">
			<a class="page-link" href="#">Previous</a>
		  </li>';
		}
		$nextData = $pageData[$count] + 1;
		if($nextData > $totalLinks){
		  $nextLink = '
		  <li class="page-item disabled">
			<a class="page-link" href="#">Next</a>
		  </li>';
		} else {
		  $nextLink = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$nextData.'">Next</a></li>';
		}
	  } else {
		if($pageData[$count] == '...'){
		  $pageLink .= '
		  <li class="page-item disabled">
			  <a class="page-link" href="#">...</a>
		  </li>';
		} else {
		  $pageLink .= '
		  <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$pageData[$count].'">'.$pageData[$count].'</a></li>';
		}
	  }
	}
	
	$output .= $previousLink . $pageLink . $nextLink;
	echo $output;


?>