<?php

require 'config.php';

	// $host = "304.itpwebdev.com";
	// $user = "";
	// $pass = "";
	// $db = "";

	// Establish MySQL Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// Check for any Connection Errors.
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	// Retrieve all cuisines from the DB.
	$sql_cuisine = "SELECT * FROM category_cuisines;";

	$results_cuisine = $mysqli->query( $sql_cuisine );

	// Check for SQL Errors.
	if ( !$results_cuisine ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	

	// Retrieve results from the DB.
	$sql = "SELECT restaurant_reviews.restaurant_name AS restaurant, category_cuisines.category_cuisine AS cuisine
					FROM restaurant_reviews
					LEFT JOIN category_cuisines
						ON restaurant_reviews.category_id = category_cuisines.category_id
					WHERE 1 = 1";

	if ( isset($_GET['restaurant_name']) && trim($_GET['restaurant_name']) != '' ) {
		$restaurant_name = $_GET['restaurant_name'];
		$restaurant_name = $mysqli->escape_string($restaurant_name);
		$sql = $sql . " AND restaurant_reviews.restaurant_name LIKE '%$restaurant_name%'";
	}

	if ( isset( $_GET['cuisine_id'] ) && trim( $_GET['cuisine_id'] ) != '' ) {
		$cuisine_id = $_GET['cuisine_id'];
		$sql = $sql . " AND restaurant_reviews.category_id = $cuisine_id";
	}


	$sql = $sql . ";";

	// echo "<hr>$sql<hr>";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	/*
		Things we need to know for pagination:
		1. start index for 'LIMIT' SQL Clause
		2. # of restuls per page for 'LIMIT' SQL Clause
		3. Currrent Page #
	*/

	$total_results = $results->num_rows;
	$result_per_page = 10;
	$last_page = ceil($total_results / $result_per_page);

	if (isset($_GET['page']) && trim($_GET['page']) != '') {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}

	if ($current_page < 1 || $current_page > $last_page) {
		$current_page = 1;
	}

	$start_index = ($current_page - 1) * $result_per_page;

	// echo "<hr>";
	// echo $sql;

	$sql = rtrim($sql, ';');

	// echo "<hr>";
	// echo $sql;

	$sql = $sql . " LIMIT $start_index, $result_per_page;";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Close MySQL Connection.
	$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kezpezfood Website</title>
    <meta name="description" content="Kezpezfood tells you the best restaurants in LA but I also have so many on my list I haven't tried yet. Check out this database to of food spots I haven't tried yet but really want to. ">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
     /* color scheme: */
     #header{
    background-color: #8C31FF;
    background-size: cover;
    background-position: center;
    text-align: center;
    /* display:flex; */
    position: relative;
    line-height: 30px;
    width: auto;
    height: auto;
    color: white;
    margin: 0px;
    margin-bottom: 20px;
    padding-bottom: 80px;

    
    
}
   

    ul.checkbox-list {
        list-style: none;
        padding: 0; 
        margin: 10px; 
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
.reg_btn{
    background-color: white; /* Your custom color */
    color: black; /* Text color for better visibility, adjust as needed */
	font: 'Rubrik';
}
.reg_btn:hover {
    background-color: white; /* Your custom color */
    color: #8C31FF; /* Text color for better visibility, adjust as needed */
	font: 'Rubrik';

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
.highlight {
    background-color: #8C31FF; /* Set the background color to yellow */
    padding: 5px; 
    border-radius: 5px; /* Optional: Add rounded corners for a better look */
	display: inline-block;
	white-space: nowrap;
	color: white;
}


@media (min-width: 576px) { 
      

    }
    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768) {
		.search_btn{
    background-color: #8C31FF; /* Your custom color */
    color: #fff; /* Text color for better visibility, adjust as needed */
	float: left;
}

    }
    /* Large devices (desktops, 99
/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) {
	.search_btn{
    background-color: #8C31FF; /* Your custom color */
    color: #fff; /* Text color for better visibility, adjust as needed */
	align: left;
}
    

}
.pagination .page-item {
    box-shadow: none; 
	float: left;
}
.pagination .page-item .hover {
    background-color: none;
}
.pagination .page-link {
    border: none; 
}

.pagination .page-item .active {
	box-shadow: none;
	border: none;
}
    </style>
</head>
<body>
    <div id="logo" class="row">
        <div id="top"></div>
        <h2 class="p-3 col-12 text-center">KEZPEZFOOD</h2>
</div>

<!-- navigation bar -->
<div class="topnav">
    <!-- <a href="#home" id="logo" class="active bold">KEZPEZFOOD</a> -->
    <!-- Navigation links (hidden by default) -->
    <div id="myLinks">
        <a href="home_page.html">home</a>
        <a href="LA_pagination.php">los angeles</a>
        <a href="korean.html">korean food</a>
        <a href="cafes.html">cafes</a>
    </div>

    <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>



<div id="header" class="container-fluid">
    <div class="row">
        <div id="top"></div>
        <h2 class="p-3 col-12 text-center">choose a category</h2>
        <div class="word_slider">
            <div class="left_header_word" href="home_page.html">KEZPEZFOOD</div>
            <div class="center_header_word" href="los_angeles.html">LOS ANGELES</div>
            <div class="right_header_word" href="korean.html">KOREAN</div>
        </div><!-- text slider -->
    </div>
</div>

<!-- intro -->


	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Search a Restaurant</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
<!-- method='GET' -->
		<form id="#search-form" method='GET'>

			<div class="form-group row">
				<label for="name-id" class="col-sm-3 col-form-label text-sm-left"><h3>Restaurant Name:</h3></label>
				<div class="col-sm-12">
					<input type="text" class="form-control" id="name-id" name="restaurant_name">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="cuisine-id" class="col-sm-3 col-form-label text-sm-left"><h3>Cuisine/Category:</h3></label>
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
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn search_btn"><h3>Search</h3></button>
					<button type="reset" class="btn btn-light reset_btn"><h3>Reset</h3></button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Restaurant List</h1>
		</div> <!-- .row -->
		<div class="row">
		<a href="add_data.php" class="btn reg_btn" > Add</a>
		<a href="edit_data.php" class="btn reg_btn" > Edit</a>

		</div><!-- .row -->
	<div class="row">
			<div class="col-12 mt-4">

				Showing 
				<div class="highlight"><?php echo $start_index + 1; ?>
				-
					<?php echo $start_index + $results->num_rows; ?>
				</div>
				of 
				<?php echo $total_results; ?>
				result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>

							<th>Restaurant name</th>
							<th>Cuisine/Cateogry</th>
						</tr>
					</thead>
					<tbody>
					<?php while ( $row = $results->fetch_assoc() ) : ?>
							<tr>
								<td>
								<?php echo $row['restaurant']; ?>
							</td>
								<td><?php echo $row['cuisine']; ?></td>
							</tr>
						<?php endwhile; ?>

					</tbody>
				</table>
				</div> <!-- .container -->

			</div> <!-- .col -->
		</div> <!-- .row -->
<!-- Inspiration from the pagination lecture -->
		<div class="col-12">
								<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item <?php 
							if ($current_page <= 1) {
								echo "disabled";
							}
						 ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = 1;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							 ?>"><<</a>
						</li>
						<li class="page-item <?php 
							if ($current_page <= 1) {
								echo "disabled";
							}
						 ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = $current_page - 1;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							 ?>"><</a>
						</li>
						<li class="page-item active">
							<a class="page-link" href="">
								<?php echo $current_page;  ?> / <?php echo $last_page; ?>
							</a>
						</li>
						<li class="page-item <?php 
							if ($current_page >= $last_page) {
								echo "disabled";
							}
						 ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = $current_page + 1;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							 ?>">></a>
						</li>
						<li class="page-item <?php 
							if ($current_page >= $last_page) {
								echo "disabled";
							}
						 ?>">
							<a class="page-link" href="<?php 
								$_GET['page'] = $last_page;
								echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
							 ?>">>></a>
						</li>
					</ul>
				</nav>
			</div> <!-- .col -->

	
	</div> <!-- .container -->
	

</div><!--page wrapper-->

<div id="footer" class="container-fluid">
    <p>Kezia Leung's Interest and Hobbies</p>
    <p>Socials: @kezpezfood</p>
</div><!-- footer -->




<script>
	function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
document.querySelector("#search-form").onsubmit = function () {
			const restaurant_name = document.querySelector("#name-id").value.trim();
			const cuisine = document.querySelector("#cuisine-id").value.trim();

			const url = 'search.php?restaurant_name=' + restaurant_name + '&cuisine_id=' + cuisine_id;

			$.ajax({
				url: url,
				dataType: 'json',
				success: function(response) {
					console.log(response);

					document.querySelector("tbody").innerHTML = '';

					for (let i = 0; i < response.length; i++) {
						displayRow(response[i].restaurant, response[i].cuisine);
					}
				},
				error: function(e) {
					alert("AJAX error");
					console.log(e);
				},
			});

			return false;
		}


		function displayRow(restaurant, cuisine) {
			var tr = document.createElement('tr');
			var tdRestaurant = document.createElement('td');
			var tdCuisine = document.createElement('td');

			tdRestaurant.innerHTML = restaurant;
			tdCuisine.innerHTML = cuisine;

			tr.appendChild(tdRestaurant);
			tr.appendChild(tdCuisine);

			document.querySelector('tbody').appendChild(tr);
		}


</script>
</body>
</html>