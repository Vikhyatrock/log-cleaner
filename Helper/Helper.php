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
   protected $_scopeConfig;
 
        
     /**
      * __construct
      *
      * @return void
      */
     public function __construct(
            Context $context,
            ScopeConfigInterface  $scopeConfig
        ) {
            $this->_scopeConfig = $scopeConfig;
            parent::__construct($context);
            
        }
    
     /**
      * getModuleEnable
      *
      * @return string
      */
     public function getModuleEnable()
      {
        return $this->_scopeConfig->getValue('logcleaner/general/module_enable');
      }     
        
     /**
      * getLogSizeToClean
      *
      * @return string
      */
     public function getLogSizeToClean()
      {
        return $this->_scopeConfig->getValue('logcleaner/general/log_size_to_clean');
      }
      
      /**
       * getLogCleanType
       *
       * @return string
       */
      public function getLogCleanType()
      {
        return $this->_scopeConfig->getValue('logcleaner/general/log_clean_type');
      }    
}