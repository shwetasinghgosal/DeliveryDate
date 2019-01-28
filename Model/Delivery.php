<?php
namespace Magikkart\DeliveryDate\Model;
use Magikkart\DeliveryDate\Helper\Conshelper;

use Magikkart\DeliveryDate\Api\DeliveryManagementInterface;



class Delivery  implements DeliveryManagementInterface
{
	protected $dataHelper;
	
	public function __construct(\Magikkart\DeliveryDate\Helper\Data $dataHelper
		
	) {	
		$this->dataHelper = $dataHelper;
		
	}
	
	public function check()
	{
		//~ $options = $this->dataHelper->getConfigValue();
		//~ print_r($options);
		die;
	} 
	
	/**
     * GET for time slot api
     * @param int $city_id
     * @return string of time slots
     */
    public function getCityTimeSlots($city_id) {
		$displayDays = $this->dataHelper->getAllConfig(Conshelper::XPATH_TOTALDAYS, 'Default'); //Get number of days display
		echo $displayDays;
		$singleDate = $this->dataHelper->getAllConfig(Conshelper::XPATH_SINGLEDATE, 'Date'); //Get number of days display
		
		//~ $particularDateTime = $this->dataHelper->getAllConfig(Conshelper::XPATH_PARTICULARDATE); //Get number of days display
		$listDate = $this->getDateList($displayDays);
		$dateDiff =  array_diff($listDate, $singleDate);
		$DisableDay = $this->getDisbaleDayList($dateDiff);
		
		//~ print_r($singleDate);
		//~ print_r($listDate);
		//~ echo 'try';
		//~ print_r($dateDiff);
		//~ 
		//~ die;
	}
	
	protected function getDateList($displayDays){
		$start_date = date('d-m-Y'); 
		$start_time = strtotime($start_date);
		$end_time = strtotime("+" . $displayDays. " day", $start_time);

		for($i=$start_time; $i<$end_time; $i+=86400)
		{
			$list[] = date('d-M-Y', $i);
		}
		return $list;
	}
	protected function getDisbaleDayList($dateDiff){
		$result = $removedArray = array();
		$disableDayTime = $this->dataHelper->getAllConfig(Conshelper::XPATH_DISABLETIME, 'DISABLE'); //Get number of days display
		$paricularDate = $this->dataHelper->getAllConfig(Conshelper::XPATH_PARTICULARDATE, 'PARTI'); //Get number of days display
		$slotArray = $this->dataHelper->getConfigValue(Conshelper::XPATH_ADDSLOTS);
		
		foreach($dateDiff as $date){
			$timestamp = strtotime($date);
			$day = date('l', $timestamp);
			$removedArray = $slotArray;
			if(isset($disableDayTime[$day]) && !empty($disableDayTime[$day])){
				$removedArray = array_diff($removedArray, $disableDayTime[$day]); ;
			}
			if(isset($paricularDate[$date]) && !empty($paricularDate[$date])){
				$removedArray = array_diff($removedArray, $paricularDate[$date]); ;
			}
			$result[] = array('date' => $date, 'time_slot' => array_values($removedArray));
			$removedArray = [];
		}
		 
		 print_r($result);
		die;
	}
}
