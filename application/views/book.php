<!DOCTYPE html>
<html>
<head>
	<title>Books Home</title>
	<?php require("partials/head.php") ?>
 	<link rel="stylesheet" type="text/css" href="/assets/css/book.css">
</head>
<body>
	<div class="container">
		<?php $this->load->view("/partials/header") ?>
		<div class="row">
			<div class="twelve columns">
				<h5><?= $all_data[0]["title"]?></h5>
				<h6>By:<?= $all_data[0]['author_name']?></h6>
			</div>
		</div>
		<div class="row">
			<div class="six columns">
				<h5>Reviews:</h5>

<?php

	foreach ($all_data as $key => $value) 
	{
?>				<div>
					<?
						$stars = intval($value["star"]);
						for($i = 0; $i < $stars ;$i++)
						{
							echo "&#9733;";
						}
						$white_starts = 5 - $stars;
						for($j=0; $j < $white_starts; $j++ )
						{
							echo "&#9734;";
						}
					?>
				</div>
				<span class="small-text"><a class="name" href="/user/<?= $value['users_id']?>"><?= $value["user_name"]?></a> says: <?= $value["review"] ?></span>
				<span class="smaller-text">Posted on: <?= date('F jS, Y',strtotime($value["created_at"]))?></span>
				<?
					if($this->session->userdata("user")[0]["id"] == $value["users_id"])
					{
						echo "<span class='smaller-text-delete'><a href='/delete_review/" . $value["review_id"] . "/" . $all_data[0]['books_id'] . "'>Delete this Review</a></span>";
					}
	}

				?> 
			</div>
			<div class="six columns add-review">
				<form method="POST" action="/add_review/<?=$all_data[0]['books_id']?>">
					<input type="hidden" name="book" value="<?= $all_data[0]['books_id'] ?>">
					<label for="review">Add A Review:</label>
					<textarea name="review" class="u-full-width"></textarea>
					<span class="bold">Rating:</span>
					<select name="rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<span>stars</span>
					<br>
					<input class="u-pull-right button-primary" type="submit" value="Submit Review">
				</form>
			</div>
		</div>
	</div>
</body>
</html>