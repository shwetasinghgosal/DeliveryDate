<?php
namespace Magikkart\DeliveryDate\Block;
 
use Magento\Framework\App\Config\ScopeConfigInterface;
 
class ParticularDate extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
	
	   /**
     * Grid columns
     *
     * @var array
     */
    protected $_columns = [];
    protected $_customerGroupRenderer;
    protected $_dayList;
    protected $_monthList;
    protected $_yearList;
    protected $_tslotList;
    protected $_getTimeRenderer;
    /**
     * Enable the "Add after" button or not
     *
     * @var bool
     */
    protected $_addAfter = true;
     /**
     * Label of add button
     *
     * @var string
     */
    protected $_addButtonLabel;
     protected function _construct()	
	{
		parent::_construct();
        $this->_addButtonLabel = __('Add');
	}
	
    protected function getDayList() {
        if (!$this->_dayList) {
            $this->_dayList = $this->getLayout()->createBlock(
                    '\Magikkart\DeliveryDate\Block\Adminhtml\Form\Field\DayArray', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_dayList;
    }
    
    protected function getMonthList() {
        if (!$this->_monthList) {
            $this->_monthList = $this->getLayout()->createBlock(
                    '\Magikkart\DeliveryDate\Block\Adminhtml\Form\Field\MonthArray', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_monthList;
    }
    protected function getYearList() {
        if (!$this->_yearList) {
            $this->_yearList = $this->getLayout()->createBlock(
                    '\Magikkart\DeliveryDate\Block\Adminhtml\Form\Field\YearArray', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_yearList;
    }
    protected function getTslotList() {
        if (!$this->_tslotList) {
            $this->_tslotList = $this->getLayout()->createBlock(
                    '\Magikkart\DeliveryDate\Block\Adminhtml\Form\Field\SlotArray', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_tslotList;
    }
    
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender() {  
        $this->addColumn(
                'day', [
            'label' => __('Day'),
            'renderer' => $this->getDayList(),
                ]
        );
        $this->addColumn(
                'month', [
            'label' => __('Month'),
            'renderer' => $this->getMonthList(),
                ]
        );
       
        $this->addColumn(
                'year', [
            'label' => __('Year'),
            'renderer' => $this->getYearList(),
                ]
        );
        $this->addColumn(
                'tslot', [
					'label' => __('Time Slot'),
					'size' => __('40'),
					'renderer' => $this->getTslotList(),
              ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
    
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row) {
        $Day = $row->getDay();
        $Month = $row->getMonth();
        $Year = $row->getYear();
        $Tslot = $row->getTslot();
        $options = [];
        if ($Day) {
            $options['option_' . $this->getDayList()->calcOptionHash($Day)]   = 'selected="selected"';
        }
        if ($Month) {
            $options['option_' . $this->getMonthList()->calcOptionHash($Month)] = 'selected="selected"';
        }
        if ($Year) {
            $options['option_' . $this->getYearList()->calcOptionHash($Year)]  = 'selected="selected"';
        }
        if ($Tslot) {
			
            if (!is_array($Tslot)) {
                $Tslot = [$Tslot];
            }
            foreach ($Tslot as $Ts) {
                $options['option_' . $this->getTslotList()->calcOptionHash($Ts)]
                    = 'selected="selected"';
            }
			
			//~ $file= '/var/www/html/magikkart/var/log/test.txt';
			//~ file_put_contents($file,print_r($this->getTslotList()->calcOptionHash($Tslot)));
			
            //~ $options['option_' . $this->getTslotList()->calcOptionHash($Tslot)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
        }
    /**
     * Render array cell for prototypeJS template
     *
     * @param string $columnName
     * @return string
     * @throws \Exception
     */
    public function renderCellTemplate($columnName)
    {
        if ($columnName == "tslot") {
            //~ $this->_columns[$columnName]['class'] = 'input-text required-entry validate-number text-center _has-datepicker';
            $this->_columns[$columnName]['style'] = 'width:200px';
        }
        return parent::renderCellTemplate($columnName);
    }
}
