<?php
//DISPLAY ERRORS TO THE BROWSER
ini_set("display_errors", 1);
require_once ("../core/app.php");

//Set the template file to be used
$objFile = new File("../core/templates/public.html");
//Read the contents of template into the object instance
$objFile->read();

// Initialize the Document object with template as its resource
$objDocument = new Document($objFile->strFileContents);
$strResourcePath = "../res";
//Initialize the router
$objRouter = new Router();
$objRouter->route();
// Process with Template
$objTemplate = new Template($objDocument, $strResourcePath);
$strHeredoc = <<<HEREDOC
<div class="lo-nav">
    
</div>
HEREDOC;
$objTemplate->addData("strTitle", "My Website");
$objNav = new Document("<html></html>");
$objTermplate->addData("htmLoNav", $htmLoNav);
$docContent = $objRouter->htmRouteContent ? $objRouter->htmRouteContent : "Page not found";
$objTemplate->addData("htmContent", $docContent);
$objTemplate->compile();
print $objTemplate->output();
?>
