<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magikkart\DeliveryDate\Block\Adminhtml\Form\Field;

class YearArray extends \Magento\Framework\View\Element\Html\Select {
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
		$yearArray = range(2017, 2080);
		//~ $options = $this->localeLists->getOptionWeekdays(true, true);
		//~ $options = array("2017", "2018", "2019", "2020");
       
       
       foreach ($yearArray as $year) {
		   $this->addOption($year, $year);
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
