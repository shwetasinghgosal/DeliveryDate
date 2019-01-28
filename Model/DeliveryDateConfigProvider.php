<?php
namespace Magikkart\DeliveryDate\Model;
use Magikkart\DeliveryDate\Helper\Conshelper;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\ScopeInterface;

class DeliveryDateConfigProvider implements ConfigProviderInterface
{
    

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
	
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
	
    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $store = $this->getStoreId();
        $disabled = $this->scopeConfig->getValue( Conshelper::XPATH_DISABLED, ScopeInterface::SCOPE_STORE, $store);
        $hourMin = $this->scopeConfig->getValue(Conshelper::XPATH_HOURMIN, ScopeInterface::SCOPE_STORE, $store);
        $hourMax = $this->scopeConfig->getValue(Conshelper::XPATH_HOURMAX, ScopeInterface::SCOPE_STORE, $store);
        $totalDays = $this->scopeConfig->getValue(Conshelper::XPATH_TOTALDAYS, ScopeInterface::SCOPE_STORE, $store);
        $format = $this->scopeConfig->getValue(Conshelper::XPATH_FORMAT, ScopeInterface::SCOPE_STORE, $store);
        $slot = $this->scopeConfig->getValue(Conshelper::XPATH_ADDSLOTS, ScopeInterface::SCOPE_STORE, $store);
       
        
        $noday = 0;
        if($disabled == -1) {
            $noday = 1;
        }

        $config = [
            'shipping' => [
                'delivery_date' => [
                    'format' => $format,
                    'disabled' => $disabled,
                    'noday' => $noday,
                    'hourMin' => $hourMin,
                    'hourMax' => $hourMax,
                    'totalDays' => $totalDays,
                    'slot' => $slot
                ]
            ]
        ];

        return $config;
    }

    public function getStoreId()
    {
        return $this->storeManager->getStore()->getStoreId();
    }
    public function addSlots()
    {
		$store = $this->getStoreId();
		$addslots = $this->scopeConfig->getValue(self::XPATH_ADDSLOTS, ScopeInterface::SCOPE_STORE, $store);
        return $addslots;
    }
}
