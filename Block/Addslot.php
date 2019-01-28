<?php
namespace Magikkart\DeliveryDate\Block;
 
use Magento\Framework\App\Config\ScopeConfigInterface;
 
class Addslot extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
	
	   /**
     * Grid columns
     *
     * @var array
     */
    protected $_columns = [];
    protected $_customerGroupRenderer;
    protected $_getTimeRenderer;
    protected $_getEnd;
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
	
   
    
    protected function getTimeRenderer() {
        if (!$this->_getTimeRenderer) {
            $this->_getTimeRenderer = $this->getLayout()->createBlock(
                    '\Magikkart\DeliveryDate\Block\Adminhtml\Form\Field\DeliveryTime', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_getTimeRenderer;
    }
    protected function getEndRenderer() {
        if (!$this->_getEnd) {
            $this->_getEnd = $this->getLayout()->createBlock(
                    '\Magikkart\DeliveryDate\Block\Adminhtml\Form\Field\DeliveryTime', '', ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->_getEnd;
    }
    
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender() {
        $this->addColumn(
                'start_time', [
            'label' => __('Start Time'),
            'renderer' => $this->getTimeRenderer(), 
                ]
        );
        $this->addColumn(
                'end_time', [
            'label' => __('End Time'),
            'renderer' => $this->getEndRenderer(), 
                ]
        );
         
      
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
    
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row) {
        $startTime = $row->getStartTime();
        $endTime = $row->getEndTime();
        $options = [];
        if ($startTime) {
            $options['option_' . $this->getTimeRenderer()->calcOptionHash($startTime)] = 'selected="selected"';
          
        }
        if ($endTime) {
            $options['option_' . $this->getEndRenderer()->calcOptionHash($endTime)] = 'selected="selected"';
            
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
        if ($columnName == "start_time") {
            $this->_columns[$columnName]['class'] = 'input-text required-entry';
            $this->_columns[$columnName]['style'] = 'width:200px';
        }
        return parent::renderCellTemplate($columnName);
    }
}
