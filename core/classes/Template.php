<?php
class Template
{
    protected Document $objDocument;
    protected Array $arrTemplateData = [];
    protected String $strResourcePath;

    public function __construct(Document $objDocument, String $strResourcePath)
    {
        $this->strResourcePath = $strResourcePath;
        $this->objDocument = $objDocument;
       
        $arrFiles = $this->fetchResources($strResourcePath);
        foreach($arrFiles as $strFile){
            $this->addResource($strFile);
        }
       
    }
    private function addResource($strFile){
        if(preg_match('/\.css$/', $strFile)){
            $linkTag = '<link rel="stylesheet" href="' . $strFile . '"/>';
            $this->objDocument->addElementToHead($linkTag);
        } elseif(preg_match('/\.js$/', $strFile)){
            $scriptTag = '<script src="' . $strFile . '"></script>';
            $this->objDocument->addElementToHead($scriptTag);
        }
    }
    public function fetchResources($strResourcePath){
        $fncFilter = function($strItem) {
            return preg_match('/\.(css|js)$/', $strItem);
        };
        $objDir = new Dir($this->strResourcePath, true);
        $arrFiles = $objDir->filter($fncFilter);
        usort($arrFiles, function($a, $b) {
        if (strpos($a, 'jquery.js') !== false) {
            return -1;
        } elseif (strpos($b, 'jquery.js') !== false) {
            return 1;
        }
        return 0;
        });
        return $arrFiles;
    }
    public function addExpression($containerId, $expression)
    {
        $element = $this->objDocument->getElementById($containerId);
        if ($element) {
            $element->nodeValue = "{{ $expression }}";
        }
    }

    public function remExpression($containerId)
    {
        $element = $this->objDocument->getElementById($containerId);
        if ($element) {
            $element->nodeValue = "";
        }
    }

    public function replaceExpressions($data)
    {
        foreach ($data as $key => $value) {
            $nodes = $this->objDocument->getNodesByXPath("//*[contains(text(), '{{ $key }}')]");
            foreach ($nodes as $node) {
                if ($this->objDocument->is_html($value)) {
                    $fragment = $this->objDocument->objDocument->createDocumentFragment();
                    $fragment->appendXML($value);
                    $node->nodeValue = str_replace("{{ $key }}", "", $node->nodeValue);
                    $node->appendChild($fragment);
                } else {
                    $node->nodeValue = str_replace("{{ $key }}", $value, $node->nodeValue);
                }
            }
        }
    }
    public function addData($key, $value)
    {
        $this->arrTemplateData[$key] = $value;
    }

    public function compile()
    {
        $this->replaceExpressions($this->arrTemplateData);
    }

    public function output()
    {
        return $this->objDocument->saveHTML();
    }
}
?>