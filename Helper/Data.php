<?php

namespace Magikkart\DeliveryDate\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
 
   

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Math\Random
     */
    protected $mathRandom;

    protected $loggerInterface;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param \Psr\Log\LoggerInterface $loggerInterface
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Math\Random $mathRandom,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->mathRandom = $mathRandom;
        $this->loggerInterface = $loggerInterface;
    }

    protected function fixValue($value)
    {
        return !empty($value) ? $value : "";
    }

    /**
     * Generate a storable representation of a value
     *
     * @param int|float|string|array $value
     * @return string
     */
    protected function serializeValue($value)
    {
        //$this->loggerInterface->debug($value);
       if (is_array($value)) {
            return serialize($value);
        } else {
            return '';
        }
    }

    /**
     * Create a value from a storable representation
     *
     * @param int|float|string $value
     * @return array
     */
    protected function unserializeValue($value)
    {
        //file_put_contents('magento2.txt',print_r(unserialize($value),true));
       // $this->loggerInterface->debug(unserialize($value));

      if (is_string($value) && !empty($value)) {
            return unserialize($value);
        } else {
            return [];
        }
    }

    /**
     * Check whether value is in form retrieved by _encodeArrayFieldValue()
     *
     * @param string|array $value
     * @return bool
     */
    protected function isEncodedArrayFieldValue($value)
    {
        if (!is_array($value)) {
            return false;
        }
        unset($value['__empty']);

        foreach ($value as $row) {
            if (!is_array($row) || !array_key_exists('header', $row)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Encode value to be used in \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param array $value
     * @return array
     */
    protected function encodeArrayFieldValue(array $value)
    {
        $result = [];
        foreach ($value as $val) {
            $resultId = $this->mathRandom->getUniqueHash('_');
            $result[$resultId] = ['header' => $this->fixValue($val)];
        }
        return $result;
    }

    /**
     * Decode value from used in \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param array $value
     * @return array
     */
    protected function decodeArrayFieldValue(array $value)
    {
        $result = [];
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('header', $row)
            ) {
                continue;
            }
            $val = $this->fixValue($row['header']);
            $result = $val;
        }
        return $result;
    }

    /** 
     * @param string $path
     * @param null $store
     * @return array|mixed 
     */
    public function getConfigValue($path, $store = null)
    {
        $value = $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        $value = $this->unserializeValue($value);
        if ($this->isEncodedArrayFieldValue($value)) {
            $value = $this->decodeArrayFieldValue($value);
        }
		$result = null;
        foreach ($value as $key=>$val) {
			$result[$val['start_time'] . ' '. $val['end_time']] = $val['start_time'] . ' '. $val['end_time'];
		}
		return $result;
    }

	 /** 
     * @param string $path
     * @param string|null $type
     * @param null $store
     * @return array|mixed 
     */
    public function getAllConfig($path, $type = null, $store = null)
    {
		
        $value = $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        	
        $array = @unserialize($value);
         if ($array === false && $value !== 'b:0;') {
			 $result = $value;
		} else{
      
			$value = $this->unserializeValue($value);
			
			if ($this->isEncodedArrayFieldValue($value)) {
				$value = $this->decodeArrayFieldValue($value);
			}
			$result = null;
		
			foreach ($value as $key=>$val) {
					
				switch($type){
					case 'Date':
						$result[] = $val['day'] .'-' .  $val['month'] . '-'. $val['year'];
						break;
					case 'Time':
						$result[] = $val;
						break;
					case 'DISABLE':
						$result[$val['day']] = $val['tslot'];
						break;
					case 'PARTI':
					$result[$val['day'] .'-' .  $val['month'] . '-'. $val['year']] = $val['tslot'];
					
						break;
					case 'Default':
						$result[] = $val;
				}
				
				
			}
		}
		
		//~ print_r($result);
		return $result;
		
		
    }

    /**
     * Make value readable by \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param string|array $value
     * @return array
     */
    public function makeArrayFieldValue($value)
    {
        //$this->loggerInterface->debug($value);

        $value = $this->unserializeValue($value);

        //$this->loggerInterface->debug($value);

        if ($this->isEncodedArrayFieldValue($value)) {
            unset($value['__empty']);
            $value = $this->encodeArrayFieldValue($value);

        }else{
            $value = "";
        }
        return $value;
    }

    /**
     * Make value ready for store
     *
     * @param string|array $value
     * @return string
     */
    public function makeStorableArrayFieldValue($value)
    {
        if (!$this->isEncodedArrayFieldValue($value)) {
            $value = $this->decodeArrayFieldValue($value);
        }

        $value = $this->serializeValue($value);
        return $value;
    }

}
