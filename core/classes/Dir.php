<?php
class Dir{
    public $arrDirList;
    public $strDirPath;
    
    public function __construct($strDirPath, $bolRecursive = false){
        $this->arrDirList = [];
        $this->strDirPath = $strDirPath;
        if (!is_dir($this->strDirPath)) {
            throw new Exception("Directory does not exist: " . $this->strDirPath);
        }
        $this->arrDirList = array_diff(scandir($this->strDirPath), array('..', '.'));
        if ($bolRecursive) {
            $this->arrDirList = array_merge($this->arrDirList, $this->recurse($this->strDirPath));
        }
    }
    
    public function recurse($strDirPath){
        $arrFiles = [];
        $arrDirs = array_diff(scandir($strDirPath), array('..', '.'));
        
        foreach($arrDirs as $strDir){
            $strFullPath = $strDirPath . DIRECTORY_SEPARATOR . $strDir;
            if (is_dir($strFullPath)){
                $arrFiles[] = $strFullPath;
                $arrFiles = array_merge($arrFiles, $this->recurse($strFullPath));
            } else {
                $arrFiles[] = $strFullPath;
            }
        }
        
        return $arrFiles;
    }

    public function cd($strDirPath){
        $this->strDirPath = $strDirPath;
        if (!is_dir($this->strDirPath)) {
            throw new Exception("Directory does not exist: " . $this->strDirPath);
        }
        $this->arrDirList = array_diff(scandir($this->strDirPath), array('..', '.'));
    }

    public function filter($fnFilter){
        $arrReturn = [];
        foreach($this->arrDirList as $strDirItem){
            if($fnFilter($strDirItem)){
                array_push($arrReturn, $strDirItem);
            }
        }
        return $arrReturn;
    }
}


?>