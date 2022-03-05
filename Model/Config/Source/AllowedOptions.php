<?php 
namespace Future\LogCleaner\Model\Config\Source;

class AllowedOptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'delete', 'label' => __('Delete')]        ];
    }
}
 
