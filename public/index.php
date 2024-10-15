<?php

ini_set("display_errors", 1);
require_once ("../core/app.php");

// Read the HTML file
$objFile = new File("../core/templates/public.html");
$objFile->read();
$strFileContents = $objFile->strFileContents;

// Initialize the Document object
$objDocument = new Document($strFileContents);
$strResourcePath = "../res";
//Initialize the router
$objRouter = new Router();
$objRouter->route();
// Process with Template
$objTemplate = new Template($objDocument, $strResourcePath);
$objTemplate->addData("strTitle", "My Website");
$docContent = $objRouter->htmRouteContent ? $objRouter->htmRouteContent : "Page not found";
$objTemplate->addData("htmContent", $docContent);
$objTemplate->compile();
print $objTemplate->output();
?>
