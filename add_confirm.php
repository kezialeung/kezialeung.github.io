<?php 
// var_dump($_POST);
if (!isset($_POST['restaurant_name']) || trim($_POST['restaurant_name']) == ''
|| !isset($_POST['cuisine_id']) || trim($_POST['cuisine_id']) == ''
) {
    $error = "Please fill out all required fields.";
} else {
    require 'config.php';

// DB Connection.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}


$restaurant_name = $_POST['restaurant_name'];

$cuisine_id = $_POST['cuisine_id'];



if (isset($_POST['price_id']) && !empty($_POST['price_id'])) {
    $price_id = $_POST['price_id'];
} else {
    $price_id = "null";
}

if (isset($_POST['rating_id']) && !empty($_POST['rating_id'])) {
    $rating_id = $_POST['rating_id'];
} else {
    $rating_id = "null";
}

if (isset($_POST['link']) && !empty($_POST['link'])) {
    $link = $_POST['link'];
} else {
    $link = "null";
}



$sql = "INSERT INTO restaurant_reviews (restaurant_name, category_id, rating_id, review_link, price_id)
        VALUES ('$restaurant_name', $cuisine_id, $rating_id,  '$link', $price_id);";

// echo $sql;

$result = $mysqli->query($sql);

if (!$result) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
}

$mysqli->close();



}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Confirming Added restaurant</title>
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
						 <div class="success">was successfully added to my foodie database.</div>
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