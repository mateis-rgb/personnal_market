<?php
	session_start();

	include("./Classes/FileSystem.php");

	if (isset($_SESSION["uid"]))
	{
		echo "connected as ". $_SESSION["uid"] ."!";
	}
	else
	{
		echo "connected as guest!";
	}

	$file = new File("./products.json");

	$file->readFile();

	$magasin = $file->getContent();

	print_r($magasin);
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Magasin</title>
	</head>
	<body>
		
	</body>
</html>