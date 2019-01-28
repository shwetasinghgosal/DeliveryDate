<?php

namespace Magikkart\DeliveryDate\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;

class Conshelper extends AbstractHelper
{
		
		//Delivery slot
		const XPATH_FORMAT = 'magikkart_deliverydate/general/format';
		const XPATH_DISABLED = 'magikkart_deliverydate/general/disabled';
		const XPATH_HOURMIN = 'magikkart_deliverydate/general/hourMin';
		const XPATH_HOURMAX = 'magikkart_deliverydate/general/hourMax';
		const XPATH_TOTALDAYS = 'magikkart_deliverydate/general/totalDays';
		const XPATH_ADDSLOTS = 'magikkart_deliverydate/deliveryslots/addslot';
		const XPATH_SINGLEDATE = 'magikkart_deliverydate/deliveryslots/singledate';
		const XPATH_DISABLETIME = 'magikkart_deliverydate/deliveryslots/disabletime';
		const XPATH_PARTICULARDATE = 'magikkart_deliverydate/deliveryslots/particulardate';
		
		
}


