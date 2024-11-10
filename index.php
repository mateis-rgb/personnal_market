<?php
	session_start();

	include("./Classes/FileSystem.php");

	$login_message = "connected as guest!";

	if (isset($_SESSION["uid"]))
	{
		$login_message = "connected as ". $_SESSION["uid"] ."!";
	}

	$file = new File("./products.json");

	$file->readFile();

	$magasin = $file->toJSON();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Magasin</title>
	</head>

	<body class="bg-gray-50 text-gray-900 font-sans antialiased">
		<div class="fixed top-0 left-0 z-50 w-full h-16 <?=$_SESSION['uid'] ? 'bg-green-500' : 'bg-red-500'; ?> border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600 flex items-center justify-left">
			<span class="text-white ml-4">
				<?= $login_message; ?>	
			</span>
		</div>	

		<div class="container mx-auto p-6">
			<h1 class="text-3xl font-semibold text-center mb-6">Liste des Produits</h1>

			<table class="min-w-full table-auto bg-white rounded-lg shadow-lg overflow-hidden">
				<thead class="bg-gray-200 text-gray-700">
					<tr>
						<th class="py-3 px-4 text-left font-medium">Nom</th>
						<th class="py-3 px-4 text-center font-medium">Valeur</th>
						<th class="py-3 px-4 text-right font-medium">Action</th>
					</tr>
				</thead>

				<tbody>
					<?php
						foreach ($magasin as $category => $items) {
							if (count(array_keys((array)$items)) > 0)
							{	
								echo "<tr class=\"border-t border-gray-400\"><th class=\"py-2 px-4 pl-16 text-left text-lg font-bold\" colspan='3'>" . ucfirst($category) . "</th></tr>";
							}
							
							foreach ($items as $key => $value) {
								echo "<tr class=\"border-t border-gray-300\">";
								echo "<td class=\"py-2 px-4 text-left\">$key</td>";
								echo "<td class=\"py-2 px-4 text-center\">$value</td>";
								echo "<td class=\"py-2 px-4 text-right\">";
								echo "<div class=\"inline-flex rounded-md shadow-sm\" role=\"group\">";
								echo "<a class=\"px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-l border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition\" href=\"?cat=$category&key=$key&value=$value&method=inc\"><button class=\"font-bold\">+</button></a>";
								if ($value != 0) echo "<a class=\"px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-l border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition\" href=\"?cat=$category&key=$key&value=$value&method=dec\"><button class=\"font-bold\">-</button></a>";
								echo "<a class=\"px-4 py-2 text-sm font-medium text-red-500 bg-transparent border border-gray-900 rounded-e-lg hover:bg-red-500 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition\" href=\"?cat=$category&key=$key&value=$value&method=del\"><button class=\"font-bold\">x</button></a>";
								echo "</td>";
								echo "</tr>";
							}
						}
					?>
				</tbody>
			</table>
		</div>

		<?php include("menu.php"); ?>
		<?php include("includes.php"); ?>
	</body>
</html>