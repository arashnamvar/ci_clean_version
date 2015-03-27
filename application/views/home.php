<!DOCTYPE html>
<html>
<head>
	<title>Books Home</title>
	<?php require("partials/head.php") ?>
 	<link rel="stylesheet" type="text/css" href="/assets/css/home.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="six columns">
				<h2>Welcome, <? echo $this->session->userdata("user")[0]["name"] ?>!</h2>
			</div>
			<div class="six columns nav">
				<a class="logout" href="/add">Add Book and Review</a>
				<a class="logout real" href="/logout">Logout</a>
			</div>
		</div>
		<div class="row">
			<div class="six columns recent-book-review">
			<h5>Recent Book Reviews:</h5>
			<?php 
				foreach ($data[0] as $key => $value) {
					 
			 ?>
				
				<a class="book-title" href="/book/<?=$value["book_id"];?>"><?=$value['book_title'];?></a>
				<div>
					<?
						$stars = intval($value['review_rating']);
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
				<span class="small-text"><a class="name" href="/user/<?=$value['user_id'];?>"><?=$value['user_name'];?></a> says: <?=$value['review'];?></span>
				<span class="smaller-text">Posted on <?= date('F jS, Y',strtotime($value["created_at"]))?></span>
			<? } ?>
			</div>
			<div class="six columns">
				<h5>Other Books with Reviews:</h5>
				<div class="other-books">
				<?php 
					foreach ($data[1] as $key2 => $value2) 
					{
						echo '<a href="/book/' . $value2['book_id'] . '">' . $value2['book_title'] . '</a>';
					 }
				 ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>