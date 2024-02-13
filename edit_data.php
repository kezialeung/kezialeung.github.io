<?php
session_start();

require 'config.php';

// DB Connection.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');
if (isset($_POST['restaurant_name'])) {
    $_SESSION['restaurant_name'] = $_POST['restaurant_name'];
} 

// ratings:
$sql_ratings = "SELECT * FROM ratings;";
$results_ratings = $mysqli->query($sql_ratings);
if ( $results_ratings == false ) {
	echo $mysqli->error;
	$mysqli->close();
	exit();
}

// // price:
$sql_price = "SELECT * FROM price;";
$results_price = $mysqli->query($sql_price);
if ( $results_price == false ) {
    echo "Error executing price query: " . $mysqli->error;	$mysqli->close();
	exit();
}
// // category_cuisine:
$sql_cuisine = "SELECT * FROM category_cuisines;";
$results_cuisine = $mysqli->query($sql_cuisine);
if ( $results_cuisine == false ) {
	echo $mysqli->error;
	$mysqli->close();
	exit();
}


	// Close DB Connection
	$mysqli->close();



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit a Restaurant in the Kezpezfood DB</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
        .search_btn{
    background-color: #8C31FF; /* Your custom color */
    color: #fff; /* Text color for better visibility, adjust as needed */
}
.search_btn:hover {
    background-color: #DAC8FD; /* Adjust the hover color as needed */
	color: #8C31FF; 
}
.reset_btn{
    background-color: white; /* Your custom color */
    color: black; /* Text color for better visibility, adjust as needed */
}
#submission{
	display: none;
}
#search-form .form-control {
    border: none; /* Remove border */
    border-bottom: 1px solid #ccc; /* Add a bottom border for the line effect */
    border-radius: 0; /* Remove border-radius */
    box-shadow: none; /* Remove box shadow */
    padding: 5px 0; /* Adjust padding as needed */
}

#search-form .form-control:focus {
    border-color: #8C31FF; /* Change border color on focus if desired */
    box-shadow: none; /* Remove box shadow on focus */
}
/* Your custom CSS file Inspiration from online but didn't copy*/ 

.form-group .form-control:hover,
.form-group .form-control:focus,
.form-group .form-control:active,
.form-group .form-control.open {
    background-color: #8C31FF !important; /* Add !important to ensure it takes precedence */
    color: #fff !important; /* Add !important to ensure it takes precedence */
}

/* Optionally, you can style the selected option */
.form-group .form-control option:checked {
    background-color: #8C31FF !important; /* Add !important to ensure it takes precedence */
    color: #fff !important; /* Add !important to ensure it takes precedence */
}

.delete{
    background-color: white;
    color: red;
}
	</style>
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4 center">Edit a Restaurant in my database!</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

	<form action="edit_confirm.php" method="POST">

			
            <div class="form-group row">
				<label for="name-id" class="col-sm-12 col-form-label text-sm-left"><h3>Restaurant Name:<span class="text-danger">*</span></h3></label>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="name-id" name="restaurant_name">

				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="cuisine-id" class="col-sm-3 col-form-label text-sm-left"><h3>Cuisine/Category:<span class="text-danger">*</span></h3></label>
				<div class="col-sm-12">
					<select name="cuisine_id" id="cuisine-id" class="form-control">
						<option value="" selected><h3>-- All --</h3></option>

						<?php while ( $row = $results_cuisine->fetch_assoc() ) : ?>
							<option value="<?php echo $row['category_id']; ?>">
								<?php echo $row['category_cuisine']; ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
            
            <div class="form-group row">
				<label for="rating-id" class="col-sm-3 col-form-label text-sm-left"><h3>Rating:</h3></label>
				<div class="col-sm-12">
					<select name="rating_id" id="rating-id" class="form-control">
						<option value="" selected><h3>-- All --</h3></option>

						<?php while ( $row = $results_ratings->fetch_assoc() ) : ?>
							<option value="<?php echo $row['rating_id']; ?>">
								<?php echo $row['rating']; ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
            <div class="form-group row">
				<label for="price-id" class="col-sm-3 col-form-label text-sm-left"><h3>Price:</h3></label>
				<div class="col-sm-12">
					<select name="price_id" id="price-id" class="form-control">
						<option value="" selected><h3>-- All --</h3></option>

						<?php while ( $row = $results_price->fetch_assoc() ) : ?>
							<option value="<?php echo $row['price_id']; ?>">
								<?php echo $row['Price']; ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>

			</div> <!-- .form-group -->

            <div class="form-group row">
				<label for="link" class="col-sm-12 col-form-label text-sm-left"><h3>Instagram Link:</h3></label>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="link" name="link">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<div class="ml-auto col-sm-9">

					<span class="text-danger font-italic">* Required</span>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn search_btn">Submit</button> <button type="reset" class="btn reset btn">Reset</button>
      
                  
			</div> <!-- .form-group -->

		</form>

        <form action="delete.php" method="POST">
    <!-- Include any data you want to send as hidden inputs -->
    <input type="hidden" id="name-id" name="restaurant_name" value="<?php echo htmlspecialchars($_SESSION['restaurant_name']); ?>">
    <button type="submit" class="btn delete">X Delete</button>
</form>
	</div> <!-- .container -->
    <script>
          document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('delete-btn').addEventListener('click', function () {
            <?php
            // Set the session variable using JavaScript
            echo "localStorage.setItem('restaurant_name', '" . $_POST['restaurant_name'] . "');";
            ?>
        });
    });
        </script>
</body>
</html>