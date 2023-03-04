<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="login-container">
		<h1>Login</h1>
		<form action="Login.php" method="POST">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" placeholder="Enter your username" required>

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" placeholder="Enter your password" required>

			<input type="submit" value="Login">
		</form>
	</div>
</body>
</html>
