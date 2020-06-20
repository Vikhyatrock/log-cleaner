<?php

namespace Future\LogCleaner\Model;

use Psr\Log\LoggerInterface;
use Future\LogCleaner\Helper\LogHelper;


class Cron
{

    protected $helper;

    protected $logger;

    public function __construct(
        LogHelper $helper,
        LoggerInterface $logger
    ) {        
        $this->helper = $helper;
        $this->logger = $logger;
    }
    
  

    
    public function processLogs()
    {
        try{
               
            $this->helper->execute();

            } catch (\Exception $e) {
                $this->logger->critical('Log Clean up', ['exception' => $e]);
            }
    }

     
}
