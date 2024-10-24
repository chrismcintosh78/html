<?php
/**
 * Class File
 * 
 * This class provides methods to handle file operations such as creating, reading, writing, appending, deleting, copying, and moving files.
 */
class File {
    public $strFilePath;
    public $strFileContents;
    public $arrFileAttributes;

    /**
     * Constructor
     * 
     * @param string|null $strFilePath The path to the file.
     * @throws Exception If the file does not exist.
     */
    public function __construct($strFilePath=null) {
        if($strFilePath!=null && file_exists($strFilePath)){
            $this->strFilePath = $strFilePath;
            $this->loadFileAttributes();
        }else{
            throw new Exception("File does not exist.");
        }
    }

    pubic function getFileAttribs(){
        $this->arrFileAttribs = [];
        $this->arrFileAttribs["atime"] = '';
        $this->arrFileAttribs['mtime'] = '';
        $this->arrFileAttribs['ctime'] = '';
        $this->arrFileAttribs['size'] = '';
    }
    /**
     * Create a new file
     * 
     * @param string $strNewFilePath The path to the new file.
     * @param string $strContent The content to write to the new file.
     */
    public function create($strNewFilePath, $strContent){
        file_put_contents($strNewFilePath, $strContent);
        $this->strFilePath = $strNewFilePath;
        $this->loadFileAttributes();
    }

    /**
     * Read the file
     * 
     * @return bool True if the file is readable and the content is loaded, false otherwise.
     */
    public function read(){
        if(is_readable($this->strFilePath)){ 
            $this->strFileContents = file_get_contents($this->strFilePath);
            return true;
        }
        return false;
    }

    /**
     * Write to the file
     * 
     * @param string $strContent The content to write to the file.
     * @return bool True if the file is writable and the content is written, false otherwise.
     */
    public function write($strContent){
        if(is_writable($this->strFilePath)){
            file_put_contents($this->strFilePath, $strContent);
            $this->strFileContents = $strContent;
            return true;
        }
        return false;
    }

    /**
     * Append content to the file
     * 
     * @param string $strContent The content to append to the file.
     */
    public function append($strContent){
        $this->read();
        $this->strFileContents.= "\n". $strContent;
        file_put_contents($this->strFilePath, $strContent, FILE_APPEND);
    }

    /*
    STATIC METHODS
    */

    /**
     * Delete a file
     * 
     * @param string $strFilePath The path to the file to delete.
     * @return bool True if the file is writable and deleted, false otherwise.
     */
    public static function delete($strFilePath){
        if(is_writable($strFilePath)){
            unlink($strFilePath);
            return true;
        }
        return false;
    }

    /**
     * Copy a file
     * 
     * @param string $strSourcePath The path to the source file.
     * @param string $strDestinationPath The path to the destination file.
     */
    public static function copy($strSourcePath, $strDestinationPath){
        $strNewFilePath = $strSourcePath;
        $arrAttributes = pathinfo($strSourcePath);
        $strNewFilePath = $arrAttributes['dirname'].'/'.str_replace($arrAttributes['filename'], $arrAttributes['filename'].'.copy', $arrAttributes['basename']);
        copy($strSourcePath, $strNewFilePath);
    }

    /**
     * Move a file
     * 
     * @param string $strSourcePath The path to the source file.
     * @param string $strDestinationPath The path to the destination file.
     */
    public static function move($strSourcePath, $strDestinationPath){
        $strNewFilePath = $strDestinationPath;
        $arrAttributes = pathinfo($strSourcePath);
        $strNewFilePath = $arrAttributes['dirname'].'/'.str_replace($arrAttributes['filename'], $arrAttributes['filename'].'.moved', $arrAttributes['basename']);
        rename($strSourcePath, $strNewFilePath);
    }/**
 * Load file attributes
 * 
 * Loads the file attributes using the pathinfo function and additional file information such as mime type, size, modification time, access time, creation time, permissions, owner, and group.
 */
public function loadFileAttributes() {
    $this->arrFileAttributes = pathinfo($this->strFilePath);
    $this->arrFileAttributes['mime_type'] = mime_content_type($this->strFilePath);
    $this->arrFileAttributes['size'] = filesize($this->strFilePath);
    $this->arrFileAttributes['mtime'] = filemtime($this->strFilePath);
    $this->arrFileAttributes['atime'] = fileatime($this->strFilePath);
    $this->arrFileAttributes['ctime'] = filectime($this->strFilePath);
    $this->arrFileAttributes['permissions'] = fileperms($this->strFilePath);
    $this->arrFileAttributes['owner'] = fileowner($this->strFilePath);
    $this->arrFileAttributes['group'] = filegroup($this->strFilePath);
    $this->arrFileAttributes['is_readable'] = is_readable($this->strFilePath);
    $this->arrFileAttributes['is_writable'] = is_writable($this->strFilePath);
    $this->arrFileAttributes['is_executable'] = is_executable($this->strFilePath);
}
    /**
     * Generate a new file path based on an action
     * 
     * @param string $strSourcePath The path to the source file.
     * @param string $action The action to append to the filename.
     * @return string The new file path.
     */
    private static function generateNewFilePath($strSourcePath, $action){
        $arrAttributes = pathinfo($strSourcePath);
        $newFilename = $arrAttributes['filename'] . '.' . $action;
        $strNewFilePath = $arrAttributes['dirname'] . '/' . $newFilename;
        return $strNewFilePath;
    }   
}
?>
