<!DOCTYPE html>
<html>
<head>
	<title>Books Home</title>
	<?php require("partials/head.php") ?>
 	<link rel="stylesheet" type="text/css" href="/assets/css/add.css">
</head>
<body>
	<div class="container">
<?php $this->load->view("/partials/errors") ?>
		<?php $this->load->view("/partials/header") ?>
		<div class="row">
			<div class="twelve columns">
				<h5>Add a New Book title and a Review:</h5>
			</div>
		</div>
		<form method="POST" action="/add_book">
			<div class="row">
				<div class="ten columns">
					<label for="book_title">Book Title:</label>
					<input class="u-full-width" type="text" name="book_title">
					<label for="author1">Author:</label>
					<span class="title-form">Choose from the list:</span>
					<select name="author1">
						<option value=""></option>
						<?php 
							foreach ($aut as $key => $value) {
								foreach ($value as $key1 => $value1) {
									echo '<option value="' . $value1 . '">' . $value1 . "</option>";
								}
							}
						 ?>
					</select>
					<br>
					<span class="title-form">Or add a new author</span>
					<input type="text" name="author2">
					<label for="review">Review:</label>
					<textarea name="review" class="u-full-width"></textarea>
					<label for="rating">Rating:</label>
					<select name="rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<span>stars</span>
					<br>
					<input class="u-pull-right button-primary" type="submit" value="Add book and review">
				</div>
			</div>
		</form>
	</div>
</body>
</html>