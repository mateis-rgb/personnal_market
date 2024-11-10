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
			
			$magasin->$new_cat = '';

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

	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Magasin - Admin Mode</title>
	</head>
	<body>
		<form method="post">
			<h1>New Category Form: </h1>

			<label for="new_cat">Name: </label>
			<input type="text" name="new_cat" id="new_cat">

			<button type="submit" name="formsend_cat" id="formsend_cat">Add category</button>
		</form>

		<form method="post">
			<h1>Delete Category Form: </h1>

			<label for="del_cat">Category: </label>
			<select name="del_cat" id="del_cat">
				<option selected disabled>Select category</option>
				
				<?php
					foreach ($magasin as $key => $value)
					{
						printf("<option value=\"%s\">%s</option>%s\n", $key, $key, $key);
					}
				?>
			</select>

			<button type="submit" name="formsend_del_cat" id="formsend_del_cat">Delete category</button>
		</form>

		<form method="post">
			<h1>New Product Form: </h1>

			<div class="form-control">
				<label for="new_prod_name">Name: </label>
				<input type="text" name="new_prod_name" id="new_prod_name">
			</div>

			<div class="form-control">
				<label for="new_prod_cat">Category: </label>
				<select name="new_prod_cat" id="new_prod_cat">
					<option selected disabled>Select category</option>
					
					<?php
						foreach ($magasin as $key => $value)
						{
							printf("<option value=\"%s\">%s</option>%s\n", $key, $key, $key);
						}
					?>
				</select>
			</div>

			<div class="form-control">
				<label for="new_prod_qte">Quantity: </label>
				<input type="number" name="new_prod_qte" id="new_prod_qte">
			</div>

			<button type="submit" name="formsend_product" id="formsend_product">Add product</button>
		</form>
	</body>
</html>