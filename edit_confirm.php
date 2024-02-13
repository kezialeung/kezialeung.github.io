<?php 
// var_dump($_POST);
session_start();

if (!isset($_POST['restaurant_name']) || trim($_POST['restaurant_name']) == ''
|| !isset($_POST['cuisine_id']) || trim($_POST['cuisine_id']) == ''
) {
    $_SESSION['error'] = "Please fill out all required fields.";
    header('Location: edit_data.php'); // Redirect back to the edit_data.php page
    exit();
    $error = "Please fill out all required fields.";

} else {
    require 'config.php';

// DB Connection.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}
 // Retrieving restaurant_id based on the entered restaurant_name
 $restaurant_name = $mysqli->real_escape_string($_POST['restaurant_name']);
 $lookup_sql = "SELECT restaurant_id FROM restaurant_reviews WHERE restaurant_name = '$restaurant_name'";
 $lookup_result = $mysqli->query($lookup_sql);
// var_dump($_SESSION['restaurant_name']);
 if (!$lookup_result) {
     echo $mysqli->error;
     $error = "This restaurant doesn't exit in the database. Please add it to it!";
     $mysqli->close();
     exit();
 }

 $row = $lookup_result->fetch_assoc();
 $restaurant_id = $row['restaurant_id'];


$restaurant_name = $_POST['restaurant_name'];

$cuisine_id = $_POST['cuisine_id'];


$rating_id = isset($_POST['rating']) && trim($_POST['rating']) != '' ? "'" . $_POST['rating'] . "'" : 'null';
$price_id = isset($_POST['price']) && trim($_POST['price']) != '' ? $_POST['price'] : 'null';
$link = isset($_POST['link']) && trim($_POST['link']) != '' ? $_POST['link'] : 'null';


$sql = "UPDATE restaurant_reviews
				SET restaurant_name = '$restaurant_name',
					category_id = $cuisine_id,
					rating_id = $rating_id,
					price_id = $price_id,
					review_link = $link

				WHERE restaurant_id = $restaurant_id;";

		// echo "<hr>$sql<hr>";
        // echo $_SESSION['restaurant_name'];

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$mysqli->close();
        $_SESSION['restaurant_name'] = $_POST['restaurant_name'];



	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Confirming edits in the database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<style>
    .text-success{
        display: inline-block;
    }
    .success-1{
        color: #8C31FF;
    font-size: 18px;
    margin: 10px;
    font-family: 'Rubik', sans-serif;
    }
.success{
    color: black;
    font-size: 14px;
    margin: 10px;
    font-family: 'Rubik', sans-serif;
}
.search_btn{
    background-color: #8C31FF; /* Your custom color */
    color: #fff; /* Text color for better visibility, adjust as needed */
}
.search_btn:hover {
    background-color: #DAC8FD; /* Adjust the hover color as needed */
	color: #8C31FF; 
}
</style>



</head>
<body>
<div class="container">
		<div class="row mt-4">
			<div class="col-12">
			<?php if (isset($error) && !empty($error)) : ?>

				<div class="text-danger font-italic">
				<?php echo $error; ?>
				</div>
				<?php else:?>

					<div class="text-success">
						<div class="success-1 bold-text">							
						<?php echo $restaurant_name; ?></div>
						 <div class="success">was successfully edited in my foodie database.</div>
					</div>
				<?php endif; ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="LA_pagination.php" role="button" class="btn search_btn">Go back to the Los Angeles page</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>