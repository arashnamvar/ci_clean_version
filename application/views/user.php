<?php

$counter = 0;
foreach ($all_data as $key => $value) 
{
	$counter++;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User</title>
	<?php require("partials/head.php") ?>
 	<link rel="stylesheet" type="text/css" href="/assets/css/user.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="twelve columns nav">
				<a class="logout" href="/">Home</a>
				<a class="logout real" href="/add">Add Book and Review</a>
				<a class="logout real" href="/logout">Logout</a>
			</div>
		</div>
		<div class="row">
			<h5>User Alias: <?= $all_data[0]["user_alias"]?></h5>
			<h5>Name: <?= $all_data[0]["user_name"]?></h5>
			<h5>Email: <?= $all_data[0]["email"]?></h5>
			<h5>Total Reviews: <?= $counter;?></h5>
			<h5 class="reviews">Posted Reviews on the following books:</h5>
<?php foreach ($all_data as $key => $value) {
	echo "<a class='book-review' href='/book/" . $value['book_id'] . "'>" . $value['title'] . "</a>";
}
?>
		</div>
	</div>
</body>
</html>