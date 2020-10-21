<?php

namespace Future\LogCleaner\Logger;   

use Magento\Framework\Logger\Monolog as CoreMonolog;
use Magento\Framework\Event\ManagerInterface as EventManager;

class Monolog extends CoreMonolog
{
    private $_eventManager;

    public function __construct($name, array $handlers = [], array $processors = [],EventManager $eventManager)
    {
        
        $this->_eventManager = $eventManager;
        $handlers = array_values($handlers);
        parent::__construct($name, $handlers, $processors);
    }

    /**
     * Adds a log record.
     *
     * @param integer $level The logging level
     * @param string $message The log message
     * @param array $context The log context
     * @return bool Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = [])
    {
        /**
         * To preserve compatibility with Exception messages.
         * And support PSR-3 context standard.
         *
         * @link http://www.php-fig.org/psr/psr-3/#context PSR-3 context standard
         */

        if ($message instanceof \Exception && !isset($context['exception'])) {
            $context['exception'] = $message;
        }

        $message = $message instanceof \Exception ? $message->getMessage() : $message;

        $this->_eventManager->dispatch('future_LogCleaner_write_logs', ['error' => $message]);

        return parent::addRecord($level, $message, $context);
    }
}
