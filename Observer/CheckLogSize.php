<?php

namespace Future\LogCleaner\Observer;
use Future\LogCleaner\Helper\LogHelper;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class CheckLogSize implements ObserverInterface
{

    protected $_helper;

    public function __construct(
        LogHelper $helper
	)
	{        
        $this->_helper = $helper;
    }
    
  	public function execute(Observer $observer)
	{
		$this->_helper->execute();
	}
}