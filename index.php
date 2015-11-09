<!DOCTYPE html>
<html>
<head>
	<title>Proov Olavi Sau</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<h1>Filter by Product ID</h1>
<input type="text" class="search-box">
<?php

require_once 'olavi/config.php';
require_once 'olavi/cache.php';
use \olavi\Config as cnf;

$fileName = 'output.xml.cache';

$cache = new \olavi\Cache('cache/');

	echo '<ul id="data">';
if(!$cache->isCacheFileValid($fileName, 3600)){

	$pdo = new PDO('mysql:host='.cnf::SERVER_NAME.';dbname='.cnf::DB_NAME, cnf::USER_NAME, cnf::PASSWORD);
	$content = file_get_contents(cnf::OUTPUT_XML_URL);

	$cache->setCacheFile($fileName, $content);
	$xml = $cache->getCacheFile($fileName, 3600) or die('Cache Error');

	foreach ($xml -> product as $row) {
		$parentSku = $row -> parentSku;
		$category = $row -> category;
		$productID = $row -> productID;
		$sku = $row -> sku;
		$name = $row -> name;
		$name_en = $row -> name_en;
		$name_ru = $row -> name_ru;
		$description = $row -> description;
		$longdesc = $row -> longdesc;
		$description_en = $row -> description_en;
		$longdesc_en = $row -> longdesc_en;
		$description_ru = $row -> description_ru;
		$longdesc_ru = $row -> longdesc_ru;
		$price = $row -> price;
		$amount = $row -> amount;
		$images = $row -> images;
		$Color = $row -> Color;
		$Size = $row -> Size;

		if(isset($description) && $description != '' || (isset($description_ru) && $description_ru != '') || (isset($description_en) && $description_en != '')){
			$pdostm = $pdo->prepare("INSERT INTO descriptions (description, description_ru, description_en, productID) VALUES(:description, :description_ru,:description_en, :productID )");
			$pdostm->bindParam(":description",$description);
			$pdostm->bindParam(":description_ru",$description_ru);
			$pdostm->bindParam(":description_en",$description_en);
			$pdostm->bindParam(":productID",$productID);
			$pdostm->execute();
		}
		if(isset($category) && $category != ''){
			$pdostm = $pdo->prepare("INSERT INTO categories (category, productID) VALUES(:category, :productID )");
			$pdostm->bindParam(":category",$category);
			$pdostm->bindParam(":productID",$productID);
			$pdostm->execute();
		}
		if(isset($parentSku) && $parentSku != ''){
			$pdostm = $pdo->prepare("INSERT INTO parentsku2sku (parentSku, sku) VALUES(:parentSku,:sku)");
			$pdostm->bindParam(":parentSku",$parentSku);
			$pdostm->bindParam(":sku",$sku);
			$pdostm->execute();
		}
		$pdostm = $pdo->prepare("INSERT INTO products ( productID, sku, name, name_ru, name_en, longdesc, longdesc_ru, longdesc_en, price, amount, images, Color, Size) VALUES( :productID, :sku, :name,:name_ru,:name_en,:longdesc,:longdesc_ru,:longdesc_en,:price,:amount,:images,:Color,:Size)");
		$html = "<li class='data-container' id=".htmlspecialchars($productID)."><span class='product-id'>productID:".htmlspecialchars($productID)." </span><span>name:".htmlspecialchars($name)."</span><span>price:".htmlspecialchars($price)."</span><span>amount: ".htmlspecialchars($amount)."</span></li>";
		echo $html;
		$pdostm->bindParam(":productID",$productID);
		$pdostm->bindParam(":sku",$sku);
		$pdostm->bindParam(":name",$name);
		$pdostm->bindParam(":name_ru",$name_ru);
		$pdostm->bindParam(":name_en",$name_en);
		$pdostm->bindParam(":longdesc",$longdesc);
		$pdostm->bindParam(":longdesc_ru",$longdesc_ru);
		$pdostm->bindParam(":longdesc_en",$longdesc_en);
		$pdostm->bindParam(":price",$price);
		$pdostm->bindParam(":amount",$amount);
		$pdostm->bindParam(":images",$images);
		$pdostm->bindParam(":Color",$Color);
		$pdostm->bindParam(":Size",$Size);
		$pdostm->execute();
		
	}
	
} else {
	$xml = $cache->getCacheFile($fileName, 3600);
	foreach ($xml -> product as $row) {
		$parentSku = $row -> parentSku;
		$category = $row -> category;
		$productID = $row -> productID;
		$sku = $row -> sku;
		$name = $row -> name;
		$name_en = $row -> name_en;
		$name_ru = $row -> name_ru;
		$description = $row -> description;
		$longdesc = $row -> longdesc;
		$description_en = $row -> description_en;
		$longdesc_en = $row -> longdesc_en;
		$description_ru = $row -> description_ru;
		$longdesc_ru = $row -> longdesc_ru;
		$price = $row -> price;
		$amount = $row -> amount;
		$images = $row -> images;
		$Color = $row -> Color;
		$Size = $row -> Size;
		$html = "<li class='data-container' id=".htmlspecialchars($productID)."><span class='product-id'>productID:".htmlspecialchars($productID)." </span><span>name:".htmlspecialchars($name)."</span><span>price:".htmlspecialchars($price)."</span><span>amount: ".htmlspecialchars($amount)."</span></li>";
		echo $html;
	}
}
echo '</ul>';
?>
<script src="scripts.js"></script>
</body>
</html>
