<?php
class UI
{
    protected $doc;

    public function __construct()
    {
        $this->doc = new DOMDocument();
    }

    // Helper function to create an attribute string from an array
    private function createAttributesString($attributes)
    {
        $attrString = '';
        foreach ($attributes as $key => $value) {
            $attrString .= $key . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '" ';
        }
        return trim($attrString);
    }

    // Method to create Bootstrap classes from parameters
    private function createBootstrapClasses($params)
    {
        $classes = [];
        
        if (isset($params['buttonPadding'])) {
            $classes[] = 'p-' . $params['buttonPadding'];
        }
        if (isset($params['textWeight'])) {
            $classes[] = 'fw-' . $params['textWeight'];
        }
        if (isset($params['textSize'])) {
            $classes[] = 'fs-' . $params['textSize'];
        }
        if (isset($params['buttonMargin'])) {
            $classes[] = 'm-' . $params['buttonMargin'];
        }
        if (isset($params['backgroundColor'])) {
            $classes[] = 'bg-' . $params['backgroundColor'];
        }
        if (isset($params['foregroundColor'])) {
            $classes[] = 'text-' . $params['foregroundColor'];
        }
        if (isset($params['roundedTop'])) {
            $classes[] = 'rounded-top-' . $params['roundedTop'];
        }
        if (isset($params['roundedBottom'])) {
            $classes[] = 'rounded-bottom-' . $params['roundedBottom'];
        }
        if (isset($params['rounded'])) {
            $classes[] = 'rounded-' . $params['rounded'];
        }

        return implode(' ', $classes);
    }

    // Method to create a navigation bar
    public function createNavBar($strLogo, $arrItems, $arrClasses="")
    {
        $navItems = '';
        $classes = $this->createBootstrapClasses($params);

        foreach ($items as $item) {
            $navItems .= "<li class='nav-item'><a class='nav-link' href='{$item['link']}'>{$item['label']}</a></li>";
        }

        $navClasses = isset($params['navClasses']) ? $params['navClasses'] : 'navbar navbar-expand-lg navbar-light bg-light';
        $attrString = isset($params['attributes']) ? $this->createAttributesString($params['attributes']) : '';

        return "
        <nav class='$navClasses $classes' $attrString>
            <a class='navbar-brand' href='#'>$brand</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNav'>
                <ul class='navbar-nav'>
                    $navItems
                </ul>
            </div>
        </nav>";
    }

    // Method to create a row
    public function createRow($content, $attributes = [])
    {
        $attrString = $this->createAttributesString($attributes);
        return "<div class='row' $attrString>$content</div>";
    }

    // Method to create a column
    public function createColumn($content, $size = 'col', $attributes = [])
    {
        $attrString = $this->createAttributesString($attributes);
        return "<div class='$size' $attrString>$content</div>";
    }

    // Method to create a card
    public function createCard($title, $body, $footer = '', $attributes = [])
    {
        $footerContent = $footer ? "<div class='card-footer'>$footer</div>" : '';
        $attrString = $this->createAttributesString($attributes);
        return "
        <div class='card' $attrString>
            <div class='card-body'>
                <h5 class='card-title'>$title</h5>
                <p class='card-text'>$body</p>
            </div>
            $footerContent
        </div>";
    }

    // Method to create a Bootstrap icon
    public function createBootstrapIcon($name, $attributes = [])
    {
        $attrString = $this->createAttributesString($attributes);
        return "<i class='bi bi-$name' $attrString></i>";
    }

    // Method to create a Boxicon
    public function createBoxicon($name, $attributes = [])
    {
        $attrString = $this->createAttributesString($attributes);
        return "<i class='bx bx-$name' $attrString></i>";
    }

    // Method to create a Material icon
    public function createMaterialIcon($name, $attributes = [])
    {
        $attrString = $this->createAttributesString($attributes);
        return "<i class='material-icons' $attrString>$name</i>";
    }

    // Method to create a "Back to Top" button
    public function createBackToTopButton($params = [])
    {
        $classes = isset($params['classes']) ? $params['classes'] : 'btn btn-primary';
        $text = isset($params['text']) ? $params['text'] : '↑';

        $attrString = isset($params['attributes']) ? $this->createAttributesString($params['attributes']) : '';
        $style = isset($params['style']) ? $params['style'] : 'position:fixed;bottom:20px;right:20px;display:none;';

        $button = "<button id='backToTop' class='$classes' style='$style' $attrString>$text</button>";

        $script = <<<SCRIPT
        <script>
        window.onscroll = function() {
            var button = document.getElementById('backToTop');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        };
        
        document.getElementById('backToTop').onclick = function() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        };
        </script>
        SCRIPT;

        return $button . $script;
    }
}


// Initialize UI
$ui = new UI();

// Create a "Back to Top" button
$params = [
    'classes' => 'btn btn-secondary',
    'text' => '↑',
    'attributes' => ['title' => 'Back to top'],
    'style' => 'position:fixed;bottom:20px;right:20px;display:none;'
];

$backToTopButton = $ui->createBackToTopButton($params);

// Output the generated HTML
echo $backToTopButton;
