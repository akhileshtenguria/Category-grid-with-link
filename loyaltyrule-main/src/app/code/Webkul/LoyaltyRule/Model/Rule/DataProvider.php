<?php
/**
 * Webkul Software.
 *
 * PHP version 7.0+
 *
 * @category  Webkul
 * @package   Webkul_LoyaltyRule
 * @author    Webkul <support@webkul.com>
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html ASL Licence
 * @link      https://store.webkul.com/license.html
 */

namespace Webkul\LoyaltyRule\Model\Rule;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Session\SessionManagerInterface;
use Webkul\LoyaltyRule\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $session;

    /**
     * @var \Webkul\LoyaltyRule\Model\ResourceModel\Rule\Collection
     */
    protected $collection;

    /**
     * Provider configuration data
     *
     * @var array
     */
    protected $loadedData;
   
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        RuleCollectionFactory $ruleCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $ruleCollectionFactory->create();
        $this->collection->addFieldToSelect("*");
    }

    /**
     * Get Session
     *
     * @return \Magento\Framework\Session\SessionManagerInterface
     */
    protected function getSession()
    {
        if ($this->session === null) {
            $this->session = ObjectManager::getInstance()->get(SessionManagerInterface::class);
        }
        return $this->session;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $rules = $this->collection->getItems();
        foreach ($rules as $rule) {
            $result["loyalty_rule"] = $rule->getData();
            $this->loadedData[$rule->getId()] = $result;
        }
        $data = $this->getSession()->getRuleFormData();
        if (!empty($data)) {
            $ruleId = $data["loyalty_rule"]["id"] ?? null;
            $this->loadedData[$ruleId] = $data;
            $this->getSession()->unsRuleFormData();
        }
        return $this->loadedData;
    }
}
