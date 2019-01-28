<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magikkart\DeliveryDate\Block\Adminhtml\Form\Field;

use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;
  
class DeliveryTime extends \Magento\Framework\View\Element\Html\Select
{
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

  
    public function __construct(
    \Magento\Framework\View\Element\Context $context, \Magento\Customer\Model\GroupFactory $groupfactory, \Magento\Framework\Locale\ListsInterface $localeLists, array $data = []
    ) {
        parent::__construct($context, $data);
        $this->groupfactory = $groupfactory;
        $this->localeLists = $localeLists;
      
    }  
     /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml() {
		
		//~ $options = $this->localeLists->getOptionWeekdays(true, true);
		$options = array("7:00 AM" => "7:00 AM","8:00 AM" =>"8:00 AM","9:00 AM"=>"9:00 AM","10:00 AM"=>"10:00 AM","11:00 AM"=>"11:00 AM","12:00 PM"=>"12:00 PM","1:00 PM"=>"1:00 PM","2:00 PM"=>"2:00 PM","3:00 PM" => "3:00 PM","4:00 PM" => "4:00 PM","5:00 PM"=>"5:00 PM","6:00 PM" => "6:00 PM");
		//~ $options = array("7" => "7","8" =>"8");
       
       
       foreach ($options as $key=>$day) {
		   $this->addOption($key, $day);
	   }
		 return parent::_toHtml();
    }
    /**
     * Sets name for input element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value) {
        return $this->setName($value);
    }
}

