<?php 
namespace Future\LogCleaner\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface; 
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;





class Helper extends AbstractHelper
{
      
   /**
    * scopeConfig
    *
    * @var Magento\Framework\App\Config\ScopeConfigInterface
    */
   protected $scopeConfig;
 
        
     /**
      * __construct
      *
      * @return void
      */
     public function __construct(
            Context $context,
            ScopeConfigInterface  $scopeConfig
        ) {
            parent::__construct($context);
            $this->scopeConfig = $scopeConfig;
        }
 

       
     /**
      * getSupportEmail
      *
      * @return string
      */
     public function getSupportEmail():string
     {
        return  $this->scopeConfig->getValue('trans_email/ident_support/email');
     } 
     
     /**
      * getSupportName
      *
      * @return string
      */
     public function getSupportName():string
     {
        return $this->scopeConfig->getValue('trans_email/ident_support/name');
     }
     
     /**
      * getModuleEnable
      *
      * @return string
      */
     public function getModuleEnable():string
      {
        return $this->scopeConfig->getValue('logcleaner/general/module_enable');
      }     
        
     /**
      * getLogSizeToClean
      *
      * @return string
      */
     public function getLogSizeToClean():string
      {
        return $this->scopeConfig->getValue('logcleaner/general/log_size_to_clean');
      }
              
          
      /**
       * getLogBackUpEmail
       *
       * @return string
       */
      public function getLogBackUpEmail():string
      {
        return $this->scopeConfig->getValue('logcleaner/general/log_back_up_email');
      }
      
      /**
       * getLogCleanType
       *
       * @return string
       */
      public function getLogCleanType():string
      {
        return $this->scopeConfig->getValue('logcleaner/general/log_clean_type');
      }
      
      /**
       * getGoogleApiKey
       *
       * @return string
       */
      public function getGoogleApiKey():string
      {
        return $this->getProjectBasePath()."/".$this->scopeConfig->getValue('logcleaner/cloud/google_api');
      }
      
      /**
       * getCloudBackUpEnabled
       *
       * @return string
       */
      public function getCloudBackUpEnabled():string
      {
        return $this->scopeConfig->getValue('logcleaner/cloud/cloud_backup');
      }
      
      /**
       * getProjectId
       *
       * @return string
       */
      public function getProjectId():string
      {
        return $this->scopeConfig->getValue('logcleaner/cloud/project_id');
      }
      
      /**
       * getBucketName
       *
       * @return string
       */
      public function getBucketName():string
      {
        return $this->scopeConfig->getValue('logcleaner/cloud/project_bucket_name');
      }
            
      /**
       * getProjectBasePath
       *
       * @return string
       */
      public function getProjectBasePath():string
      {
        return $this->scopeConfig->getValue('logcleaner/cloud/project_base_path');
      }      
      

}