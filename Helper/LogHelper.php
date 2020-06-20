<?php 
namespace Future\LogCleaner\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Future\LogCLeaner\Helper\Storage;
use Future\LogCLeaner\Helper\Helper;
use Future\LogCLeaner\Helper\Mail;
use \ZipArchive;


class LogHelper extends AbstractHelper
{   
   /**
    * zip  
    *
    * @var ZipArchive
    */
   protected $zip;
   
   /**
    * storage
    *
    * @var \Future\LogCLeaner\Helper\Storage
    */
   protected $storage;
   
   /**
    * helper
    *
    * @var \Future\LogCLeaner\Helper\Helper
    */
   protected $helper;
   
   
   /**
    * mail
    *
    * @var \Future\LogCLeaner\Helper\Mail
    */
   protected $mail;

   const  VAR_LOG_PATH = "var/log/";

   const  LOG_ZIP = "var/logs.zip";
 
      
   /**
    * __construct
    *
    * @return void
    */
   public function __construct(
       Context $context,
       ZipArchive $zip,
       Storage $storage,
       Helper $helper,
       Mail $mail
   ) {
       parent::__construct($context);
       $this->zip = $zip;
       $this->storage = $storage;
       $this->helper = $helper;
       $this->mail = $mail;
   }
 
     
   /**
    * execute
    *
    * @return void
    */
   public function execute()
   {
     if($this->helper->getModuleEnable())
        {
           if($this->sortSize($this->getFileSize($this->getFiles()))  >= $this->helper->getLogSizeToClean())
                {
                  switch($this->helper->getLogCleanType())
                    {
                        case 'delete':          
                            $this->deleteFiles($this->getFiles());
                        break;
                        case 'backupanddelete':
                            $this -> createAttachment();
                            $this->mail->send(self::LOG_ZIP);
                            $this->deleteFiles($this->getFiles());
                            $this->deleteZip();                                              
                        break;
                        case 'backupcloudanddelete':
                            $this -> createAttachment();
                            $this->helper->getCloudBackUpEnabled() ? $this->storage->uploadObject($this->getLogDate()."-log.zip",self::LOG_ZIP):"";
                            $this->deleteFiles($this->getFiles());
                            $this->deleteZip();
                        break;
                        default: 
                    break;
                   }
                }
        }          

   }
  
   
     
   /**
    * getFiles
    *
    * @return array
    */
   public function getFiles():array
     {
        $files=array();
            if (is_dir(self::VAR_LOG_PATH)){
                if ($directoryContent = opendir(self::VAR_LOG_PATH)){
                    while (($file = readdir($directoryContent)) !== false){
                      array_push($files , self::VAR_LOG_PATH.$file);
                    }
                    closedir($directoryContent);
                }                
            }          
        return $files;
     }
    
    /**
     * getLogDate
     *
     * @return string
     */
    public function getLogDate():string
     {
        return strtolower(date("j-F-Y_h:i:s-A"));
     }
   
   /**
    * createAttachment
    *
    * @return void
    */
   public function createAttachment():void
     {        
         if(is_dir(self::VAR_LOG_PATH))
           {                
                if($this->zip -> open(self::LOG_ZIP , ZipArchive::CREATE ) === TRUE) {
                    $dir = opendir(self::VAR_LOG_PATH);
                    while($file = readdir($dir)) {
                        if(is_file(self::VAR_LOG_PATH.$file)) {
                            $this->zip -> addFile(self::VAR_LOG_PATH.$file, $file);
                        }
                    }
                    $this->zip ->close();
                }
           }       
     }
   
   /**
    * getFileSize
    *
    * @param  array $files
    * @return int
    */
   public function getFileSize($files=array()):int
     {
         $totalSize=0;
            foreach($files as $file)
            {
                $totalSize = $totalSize + ((is_file($file))?filesize($file):0);
            }
         return $totalSize;
     }   
   /**
    * deleteZip
    *
    * @return boolean
    */
   public function deleteZip():boolean
   {
       return is_file(self::LOG_ZIP)?unlink(self::LOG_ZIP):false;
   }   
   /**
    * deleteFiles
    *
    * @param  mixed $files
    * @return boolean
    */
   public function deleteFiles($files=array()):boolean
    {   
         if($files)
         {
            foreach($files as $file)
            {
                (is_file($file))? unlink($file) : false;
            }
         }        
     }
      
   /**
    * sortSize
    *
    * @param  int $bytes
    * @param  string $convertTo
    * @param  int $decimalPlaces
    * @return float
    */
   public function sortSize($bytes=0, $convertTo="M", $decimalPlaces = 1):float
    {       
            $formulas = array(
                'K' => number_format($bytes / 1024, $decimalPlaces),
                'M' => number_format($bytes / 1048576, $decimalPlaces),
                'G' => number_format($bytes / 1073741824, $decimalPlaces)
            );
            return isset($formulas[$convertTo]) ? $formulas[$convertTo] : 0;
      
    }
}