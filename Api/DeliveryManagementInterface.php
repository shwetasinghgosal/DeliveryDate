<?php
namespace Magikkart\DeliveryDate\Api;

interface DeliveryManagementInterface
{
	
   
    public function check();
    
    /**
     * GET for time slot api
     * @param int $city_id
     * @return string of time slots
     */
    public function getCityTimeSlots($city_id);
  
}
