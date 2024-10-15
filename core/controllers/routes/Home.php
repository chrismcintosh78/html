<?php
class Home {
    public $htmContent;
    public function index($strSubRoute = null) {
        if ($strSubRoute) {
            $this->htmContent = "Welcome to the Home $strSubRoute Page!";

            // Explode the subroute string inside the controller
            $arrSubRouteParts = explode('/', $strSubRoute);
            /*
            // Example handling for multiple subroute parts
            if (count($arrSubRouteParts) == 2) {
                $strCategory = $arrSubRouteParts[0]; // e.g., TVs
                $strBrand = $arrSubRouteParts[1];    // e.g., Sony

                echo "Category: " . $strCategory . "<br>";
                echo "Brand: " . $strBrand;
            } else {
                echo "Invalid subroute.";
            }
            */
        } else {
            $this->htmContent = "Welcome to the Home Page!";
        }
    }
}
?>
