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
		<!-- Importation de Tailwind CSS -->
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="bg-gray-100 flex items-center justify-center min-h-screen">

		<!-- Formulaire de connexion -->
		<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
			<h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Se connecter</h2>

			<form method="POST" class="space-y-4">
				<!-- Champ Username -->
				<div class="form-control">
					<label for="uid" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
					<input type="text" name="uid" id="uid" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
				</div>

				<!-- Champ Password -->
				<div class="form-control">
					<label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
					<input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
				</div>

				<!-- Bouton de soumission -->
				<button type="submit" name="formsend" id="formsend" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
					Se connecter
				</button>
			</form>

			<!-- Message d'erreur ou autre -->
			<?php include("includes.php"); ?>

		</div>

	</body>
</html>
