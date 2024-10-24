<?php
class Nav{
    public $intID;
    public $htmNavBar;
    public $arrUrls;
    public $arrNavBarProps;

    public function __construct($intID, $strTitle=""){
        $this->arrNavBarProps = [
            'background-color' => "grey",//{UL}
            'color' => "blue",//{UL}
            "width" => "100%",//{UL}
            "border-radius" => "NONE",//TOP, BOTTOM,LEFT, RIGHT, NONE {UL}
            "strPadding" => "5px", //{UL}
            "strDirection" => "horizontal",//horizontal, vertical {UL}
        ];

        $this->objNavFragment = new DOMDocument();
        $this->objNavFragment->loadHTML("<ul></ul>");
        $this->objNavFragmentMap = new DOMXPath($this->objNavFragment);
        $this->objNavBar = $this->objNavFragmentMap->query("ul")->item(0);
        $this->objNavBar->setAttribute("class", "lo-navigation");
        $this->intID = $intID;
    }
    public function setNavBarProp($strProp, $strVal){
        $this->arrNavBarProps[$strProp] = $strVal;
    }

    public function addUrl($strUrl, $strTitle, $strIcon=""){
       $this->arrUrls[] = ['url' => $strUrl, 'title' => $strTitle, 'icon' => $strIcon];

        foreach ($this->arrUrls as $url) {
            $li = $this->objNavFragment->createElement("li");
            $a = $this->objNavFragment->createElement("a", $url['title']);
            $a->setAttribute("href", $url['url']);
            if ($url['icon']) {
                $icon = $this->objNavFragment->createElement("i");
                $icon->setAttribute("class", $url['icon']);
                $a->insertBefore($icon, $a->firstChild);
            }
            $li->appendChild($a);
            $this->objNavBar->appendChild($li);
        }
    }
    public function setClass($strTag, $strProp, $strVal){
        $this->objNavFragmentMap->query("//$strTag")->item(0)->setAttribute($strProp, $strVal);
    }
   
}
?>