<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magikkart\DeliveryDate\Block\Adminhtml\Form\Field;
use Magikkart\DeliveryDate\Helper\Conshelper;
class SlotArray extends \Magento\Framework\View\Element\Html\Select {



	 /**
     * methodList
     *
     * @var array
     */
    protected $groupfactory;
  
    /**
     * @var \Magento\Framework\Locale\ListsInterface
     */
    protected $localeLists;
   
    protected $slotlist;
	
    public function __construct(
		\Magento\Framework\View\Element\Context $context,
		\Magikkart\DeliveryDate\Helper\Data $slotlist,
		\Magento\Customer\Model\GroupFactory $groupfactory, 
		\Magento\Framework\Locale\ListsInterface $localeLists,
		array $data = []
    ) {
        parent::__construct($context, $data);
        $this->groupfactory = $groupfactory;
        $this->localeLists = $localeLists;
        $this->slotlist = $slotlist;
    }  
     /**
     * Render block HTML
     *
     * @return string
     */
     public function _toHtml() {
		
		  $options = $this->slotlist->getConfigValue(Conshelper::XPATH_ADDSLOTS);
       
            foreach ($options as $val) {
               
                    $this->addOption($val, $val);
                
            }
        
        //~ $this->setClass('cc-type-select');
        $this->setExtraParams('multiple="multiple"');
        return parent::_toHtml();
    }
     /**
     * Sets name for input element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value . '[]');
    }
}
