<?php 
namespace Future\LogCleaner\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Area;
use Magento\Store\Model\Store;

use Future\LogCLeaner\Helper\Helper;





class Mail extends AbstractHelper
{
      
   /**
    * inlineTranslation
    *
    * @var mixed
    */
   protected $inlineTranslation;
 
      
   /**
    * transportBuilder
    *
    * @var mixed
    */
   protected $transportBuilder;
 
     
   /**
    * storeManager
    *
    * @var mixed
    */
   protected $storeManager;

   
   /**
    * helper
    *
    * @var mixed
    */
   protected $helper;
 
   /**
    * SendMail constructor.
    * @param Context $context
    */
   public function __construct(
       Context $context,
       StateInterface $inlineTranslation,
       TransportBuilder $transportBuilder,
       StoreManagerInterface $storeManager,
       Helper $helper
   ) {
       parent::__construct($context);
       $this->inlineTranslation = $inlineTranslation;
       $this->transportBuilder = $transportBuilder;
       $this->storeManager = $storeManager;
       $this->helper = $helper;
   }
 
      
   /**
    * send
    *
    * @param  mixed $attachment
    * @return boolean
    */
   public function send($attachment=''):boolean
   {
       if(is_file($attachment))
       {
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('backup_notification')
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => Store::DEFAULT_STORE_ID,
                    ]
                );
            $receiverInfo = [
                'name' => $this->helper-> getSupportName(),
                'email' => $this->helper->getLogBackUpEmail()
            ];
            $senderInfo = [
                'name' => "Log Back Up",
                'email' => $this->helper->getSupportEmail()                 
            ];
            $templateVars=array();
            $templateVars[0] = array(
                'store' => Store::DEFAULT_STORE_ID,
                'customer_name' => 'Admin',
                'message'	=> 'Logs Back Up'
            );
            
            $transport->setTemplateVars($templateVars)  
            ->setFrom($senderInfo)              
            ->addTo($receiverInfo);
            $transport->addAttachment(file_get_contents($attachment)); 
            $transport = $transport->getTransport();
            return $transport->sendMessage();
       }
       return false;
   }

  
}