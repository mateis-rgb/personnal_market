<?php
	session_start();

	$admin_uid = "admin";
	$admin_password = "toto";

	if (isset($_SESSION["uid"]))
	{
		header("Location: index.php");
	}

	if (isset($_POST["formsend"]))
	{
		
		if (!empty($_POST["uid"]) && !empty($_POST["password"]))
		{
			$uid = $_POST["uid"];
			$password = $_POST["password"];
			
			if ($uid == $admin_uid && $admin_password == $admin_password)
			{
				$_SESSION["uid"] = $admin_uid;
				
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		} 	
		else
		{
			echo "Tous les champs doivent être rempli";
		}
	}

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Magasin - Login</title>
	</head>
	<body>
		<form method="POST" >
			<div class="form-control">
				<label for="uid">Username :</label>
				<input type="text" name="uid" id="uid" required>
			</div>
			
			<div class="form-control">
				<label for="password">Password :</label>
				<input type="password" name="password" id="password" required>
			</div>

			<button type="submit" name="formsend" id="formsend">Send</button>
		</form>
	</body>
</html>