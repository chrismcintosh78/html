<?php
class Layout{
    public $objDocument;
    public $objDocumentMap;
    public $objContainer;
    public $strLayoutSize;

    public function __construct(Document $objDocument, $strSize="", $arrClasses=null){
        $this->objDocument = $objDocument;
        $objBody = $this->objDocument->getTags("body")->item(0);
        $this->objContainer = $this->objDocument->createNode("div");
        $strSize = $strSize === "" ? "" : "-".$strSize;
        $this->strLayoutSize = $strSize;
        $this->objContainer->setAttribute("class", "container".$strSize);
        $this->objContainer->setAttribute("id", "div_lo_main");
        if($arrClasses!= null){
            $strClasses = implode(" ", $arrClasses);
            $strCurClasses = $this->objContainer->getAttribute("class");
            $this->objContainer->setAttribute("class", $strCurClasses . " " . $strClasses);
        }
        $objBody->insertBefore($this->objContainer, $objBody->firstChild);
    }
    public function applyPreset($strPreset){
        switch ($strPreset) {
            case "default":
                $this->addRow("div_lo_row_header");
                $this->addCol("div_lo_header", "div_lo_row_header", "12");
                $objHeader = $this->objDocument->getElementById("div_lo_header");
                $objHeader->textContent = "{{ strHeader }}";
                $this->addRow("div_lo_row_nav");
                $this->addCol("div_lo_nav", "div_lo_row_nav", "12");
                $this->addRow("div_lo_row_content");
                $this->addCol("div_lo_content_left", "div_lo_row_content", "6");
                $this->addCol("div_lo_content_right", "div_lo_row_content", "6");
                $this->addRow("div_lo_row_footer");
                $this->addCol("div_lo_footer", "div_lo_row_footer", "12");
            break;

            case "simple":
                $this->addRow("div_lo_row_top");
                $this->addCol("div_lo_top", "div_lo_row_top", "12");
                $this->addRow("div_lo_row_center");
                $this->addCol("div_lo_center", "div_lo_row_center", "12");
                $this->addRow("div_lo_row_bottom");
                $this->addCol("div_lo_bottom", "div_lo_row_bottom", "12");
            break;
            default:

        }
    }
    public function addRow($strID, $arrClasses=null){
        $objRow = $this->objDocument->createNode("div");
        $objRow->setAttribute("class", "row");
        $objRow->setAttribute("id", $strID);
        if($arrClasses!= null){
            $objRow->setAttribute("class", implode(" ", $arrClasses));
        }
        $this->objContainer->appendChild($objRow);
    }
    public function addCol($strID, $strRowID, $intSize="", Array $arrClasses=null){
        $objRow = $this->objDocument->query("//*[@id='$strRowID']")->item(0);
        $objCol = $this->objDocument->createNode("div");
        $strSizeClass = "";
        
        if($intSize){
            $strSizeClass ="col". $this->strLayoutSize . "-" . $intSize;
        }else{
            $strSizeClass ="col". $this->strLayoutSize;
        }
        $objCol->setAttribute("class",$strSizeClass);
        $objCol->setAttribute("id", $strID);
        if($arrClasses!= null){
            $objCol->setAttribute("class", implode(" ", $arrClasses));
        }
        $objRow->appendChild($objCol);
    }
}
?>