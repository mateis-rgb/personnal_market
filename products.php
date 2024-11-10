<?php
	session_start();

	if (!isset($_SESSION["uid"]))
	{
		header("Location: login.php");
	}

	include("./Classes/FileSystem.php");

	$file = new File("./products.json");

	$file_exist = $file->readFile();

	$magasin = $file->toJSON();

	if (isset($_POST["formsend_cat"]))
	{
		if (!empty($_POST["new_cat"]))
		{
			$new_cat = $_POST["new_cat"];
			
			$magasin->$new_cat = (object) null;

			$write = $file->writeFile(json_encode($magasin));

			if ($write)
			{
				print_r($magasin);
			}
		}
	}

	if (isset($_POST["formsend_del_cat"]))
	{
		if (!empty($_POST["del_cat"]))
		{
			$del_cat = $_POST["del_cat"];
			
			unset($magasin->$del_cat);

			$write = $file->writeFile(json_encode($magasin));

			if ($write)
			{
				print_r($magasin);
			}
		}
	}


	if (isset($_POST["formsend_product"]))
	{
		if (!empty($_POST["new_prod_name"]) && !empty($_POST["new_prod_cat"]) && !empty($_POST["new_prod_qte"]))
		{
			$name = $_POST["new_prod_name"];
			$cat = $_POST["new_prod_cat"];
			$qte = $_POST["new_prod_qte"];

			printf("%s\n%s\n%s", $name, $cat, $qte);

			
			if ($magasin->$cat == null)
			{
				$new = new stdClass();
	
				$new->$name = $qte;

				$magasin->$cat = $new;
			}
			else
			{	
				$magasin->$cat->{(string) $name} = (int) $qte;
			}

			$write = $file->writeFile(json_encode($magasin));

			if ($write)
			{
				print_r($magasin);
			}
		}
		else
		{
			echo "Tous les champs doivent être remplis !";
		}
	}

	if (isset($_GET["cat"]) && isset($_GET["key"]) && isset($_GET["value"]) && isset($_GET["method"]))
	{
		$cat = $_GET["cat"];
		$key = $_GET["key"];
		$value = $_GET["value"];
		$method = $_GET["method"];

		switch ($method)
		{
			case "inc":
				$magasin->$cat->{(string) $key}++;

				break;

			case "dec":
				if ($magasin->$cat->{(string) $key} != 0)
				{
					$magasin->$cat->{(string) $key}--;
				}

				break;

			case "del":
				unset($magasin->$cat->{(string) $key});

				break;
		}

		$write = $file->writeFile(json_encode($magasin));

		if ($write)
		{
			print_r($magasin);
		}
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Magasin - Admin Mode</title>
	</head>
	<body class="bg-gray-100 text-gray-900 font-sans antialiased">
		<div class="fixed top-0 left-0 z-50 w-full h-16 bg-green-500 border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600 flex items-center justify-left">
			<span class="text-white ml-4">
				<?= "connected as admin!"; ?>	
			</span>
		</div>	

		<!-- Conteneur principal -->
		<div class="container mx-auto p-6 space-y-8 mt-16 mb-24">

			<div class="flex lg:flex-row flex-col items-center justify-center gap-4">
				<!-- Formulaire pour ajouter une catégorie -->
				<div class="bg-white p-8 rounded-lg shadow-lg flex flex-col items-center justify-center">
					<h1 class="text-2xl font-semibold text-gray-800 mb-6">Nouvelle catégorie</h1>
					<form method="post" class="space-y-4">
						<div class="form-control">
							<label for="new_cat" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
							<input type="text" name="new_cat" id="new_cat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
						</div>

						<button type="submit" name="formsend_cat" id="formsend_cat" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">Ajouter catégorie</button>
					</form>
				</div>

				<div class="bg-white p-8 rounded-lg shadow-lg flex flex-col items-center justify-center">
					<!-- Formulaire pour supprimer une catégorie -->
					<h1 class="text-2xl font-semibold text-gray-800 mb-6">Suppression d'une catégorie</h1>
					<form method="post" class="space-y-4">
						<div class="form-control">
							<label for="del_cat" class="block text-sm font-medium text-gray-700">Catégorie</label>
							<select name="del_cat" id="del_cat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
								<option selected disabled>Sélectionner une catégorie</option>
								<?php
									foreach ($magasin as $key => $value) {
										printf("<option value=\"%s\">%s</option>\n", $key, ucfirst($key));
									}
								?>
							</select>
						</div>

						<button type="submit" name="formsend_del_cat" id="formsend_del_cat" class="w-full py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">Supprimer catégorie</button>
					</form>
				</div>

				<!-- Formulaire pour ajouter un produit -->
				<div class="bg-white p-8 rounded-lg shadow-lg flex flex-col items-center justify-center">
					<h1 class="text-2xl font-semibold text-gray-800 mb-6">Nouveau produit</h1>
					<form method="post" class="space-y-4">
						<div class="form-control">
							<label for="new_prod_name" class="block text-sm font-medium text-gray-700">Nom du produit</label>
							<input type="text" name="new_prod_name" id="new_prod_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
						</div>

						<div class="form-control">
							<label for="new_prod_cat" class="block text-sm font-medium text-gray-700">Catégorie</label>
							<select name="new_prod_cat" id="new_prod_cat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
								<option selected disabled>Sélectionner une catégorie</option>
								<?php
									foreach ($magasin as $key => $value) {
										printf("<option value=\"%s\">%s</option>\n", $key, ucfirst($key));
									}
								?>
							</select>
						</div>

						<div class="form-control">
							<label for="new_prod_qte" class="block text-sm font-medium text-gray-700">Quantité</label>
							<input type="number" name="new_prod_qte" id="new_prod_qte" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
						</div>

						<button type="submit" name="formsend_product" id="formsend_product" class="w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">Ajouter produit</button>
					</form>
				</div>
			</div>

			<!-- Liste des produits -->
			<div class="bg-white p-8 rounded-lg shadow-lg">
				<h1 class="text-2xl font-semibold text-gray-800 mb-6">Liste des Produits</h1>
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
								if (count(array_keys((array)$items)) > 0) {
									echo "<tr class=\"border-t border-gray-500\"><th class=\"py-2 px-4 pl-16 text-left text-lg font-bold\" colspan='3'>" . ucfirst($category) . "</th></tr>";
								}
								foreach ($items as $key => $value) {
									echo "<tr class=\"border-t border-gray-300\">";
									echo "<td class=\"py-2 px-4 text-left\">$key</td>";
									echo "<td class=\"py-2 px-4 text-center\">$value</td>";
									echo "<td class=\"py-2 px-4 text-right\">";
									echo "<div class=\"inline-flex rounded-md shadow-sm\" role=\"group\">";
									echo "<a class=\"px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-l border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white transition\" href=\"?cat=$category&key=$key&value=$value&method=inc\"><button class=\"font-bold\">+</button></a>";
									if ($value != 0) echo "<a class=\"px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-l border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white transition\" href=\"?cat=$category&key=$key&value=$value&method=dec\"><button class=\"font-bold\">-</button></a>";
									echo "<a class=\"px-4 py-2 text-sm font-medium text-red-500 bg-transparent border border-gray-900 rounded-e-lg hover:bg-red-500 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white transition\" href=\"?cat=$category&key=$key&value=$value&method=del\"><button class=\"font-bold\">x</button></a>";
									echo "</div>";
									echo "</td>";
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>

		</div>

		<?php include("menu.php"); ?>
		<?php include("includes.php"); ?>
	</body>
</html>
