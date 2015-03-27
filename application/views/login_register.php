 <!DOCTYPE html>
 <html>
 <head>
 	<title>Welcome</title>
 	<?php require("partials/head.php") ?>
 	<link rel="stylesheet" type="text/css" href="/assets/css/login_register.css">
 </head>
 <body>
 	<div class="container">
<?php $this->load->view("/partials/errors") ?>
 		<h1>Welcome!</h1>
 		<div class="row">
 			<form method="POST" action="register">
	 			<div class="six columns border">
	 				<h5 class="title-register">Register</h5>
	 				<label for="name">Name:</label>
	 				<input class="u-full-width" type="text" name="name">
	 				<label for="alias">Alias:</label>
	 				<input class="u-full-width" type="text" name="alias">
	 				<label for="email">Email:</label>
	 				<input class="u-full-width" type="text" name="email">
	 				<label for="password">Password:</label>
	 				<input class="u-full-width password-text" type="password" name="password">
	 				<span>* Password should be at least 8 characters</span>
	 				<label for="confirm_password">Confirm Password:</label>
	 				<input class="u-full-width" type="password" name="confirm_password">
	 				<input class="u-pull-right button-primary button" type="submit" value="Register">
	 			</div>	
 			</form>
 			<form method="POST" action="login">
	 			<div class="six columns border u-pull-right">
	 				<h5 class="title-login">Login</h5>
	 				<label for="email">Email:</label>
	 				<input class="u-full-width" type="text" name="email">
	 				<label for="password">Password:</label>
	 				<input class="u-full-width" type="password" name="password">
	 				<input class="u-pull-right button-primary button" type="submit" value="Login">
	 			</div>	
 			</form>
 		</div>
 	</div>
 </body>
 </html>