<?php 
namespace Future\LogCleaner\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem\DirectoryList;
use Future\LogCleaner\Helper\Helper;


class LogHelper extends AbstractHelper
{     
   
    protected $_helper;

    protected $_dir;


   public function __construct(
       Context $context,
       Helper $helper,
       DirectoryList $dir
   ) {
        $this->_helper = $helper;
        $this->_dir = $dir;
        parent::__construct($context);
       
   }
 
     
   /**
    * execute
    *
    * @return void
    */
   public function execute()
   {
     if($this->_helper->getModuleEnable())
        {
            $maxAllowedSize = (int)($this->_helper->getLogSizeToClean());
            $totalAvialableLogSize = $this->sortSize($this->getFileSize($this->getFiles()));

           if($totalAvialableLogSize >= $maxAllowedSize )
                {
                  switch($this->_helper->getLogCleanType())
                    {
                        case 'delete':          
                            $this->deleteFiles($this->getFiles());
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
   public function getFiles()
     {
         return $this->getDirContents($this->_dir->getPath('log') . "/");;
     }

    public function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }
        return $results;
    }   
    
   /**
    * getFileSize
    *
    * @param  array $files
    * @return int
    */
   public function getFileSize($files=array())
     {
         $totalSize=0;
            foreach($files as $file)
            {
                $totalSize = $totalSize + ((is_file($file))?filesize($file):0);
            }
         return $totalSize;
     }   
      
   /**
    * deleteFiles
    *
    * @param  mixed $files
    * @return boolean
    */
   public function deleteFiles($files=array())
    {   
         if($files)
         {
             foreach($files as $file)
            {                   
                if(is_file($file))
                   {                    
                    try{
                        unlink($file);
                    }
                    catch(\Exception $e)
                    {
                        //Writing to the error to logs here will cause an endless loop
                        /** it will dispatch an event and the observer will run ,
                         * attempting to delete the file again loggin another exception creating loop */
                    }                    
                   }                   
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