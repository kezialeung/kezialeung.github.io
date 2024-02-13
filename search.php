<?php

require 'config.php';



	

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$sql = "    SELECT restaurant_reviews.restaurant_name AS restaurant, category_cuisines.category_cuisine AS cuisine
                FROM restaurant_reviews
                LEFT JOIN category_cuisines
                ON restaurant_reviews.category_id = category_cuisines.category_id
                WHERE 1 = 1;";

	if ( isset($_GET['restaurant_name']) && !empty($_GET['restaurant_name']) ) {
		$restaurant_name = $_GET['restaurant_name'];
		$restaurant_name = $mysqli->escape_string($restaurant_name);
		$sql = $sql . " AND restaurant_reviews.restaurant_name LIKE '%$restaurant_name%'";
	}

	if ( isset( $_GET['cuisine_id'] ) && !empty( $_GET['cuisine_id'] ) ) {
		$cuisine_id = $_GET['cuisine_id'];
		$sql = $sql . " AND restaurant_reviews.category_id = $cuisine_id";
	}

	$sql = $sql . " LIMIT 0, 10";

	$sql = $sql . ";";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$mysqli->close();
	$all_rows = $results->fetch_all(MYSQLI_ASSOC);

	// var_dump($all_rows);

	// echo "<hr>";

	// var_dump(json_encode($all_rows));

	echo json_encode($all_rows);
    



?>