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

namespace Webkul\LoyaltyRule\Model\ResourceModel;

class RuleCategory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $store = null;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init("loyalty_rule_assigned_category", "id");
    }

    /**
     * Load an object using 'identifier' field if there's no field specified and value is not numeric
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param mixed $value
     * @param string $field
     * @return $this
     */
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && $field === null) {
            $field = "id";
        }
        return parent::load($object, $value, $field);
    }

    /**
     * Set Store
     *
     * @param \Magento\Store\Model\StoreManagerInterface $store
     *
     * return $this
     */
    public function setStore($store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * Get Store
     *
     * @return \Magento\Store\Model\StoreManagerInterface
     */
    public function getStore()
    {
        return $this->_storeManager->getStore($this->store);
    }
}
