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

namespace Webkul\LoyaltyRule\Model;

use Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class RuleCategory extends AbstractModel implements RuleCategoryInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    const NOROUTE_ID = "no-route";

    /**
     * Pos Loyalty Rule Assigned Category cache tag.
     */
    const CACHE_TAG = "loyalty_rule_assigned_category";

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'loyalty_rule_assigned_category';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory::class);
    }

    /**
     * Load Assigned Rule Pos Category
     *
     * @param int $status
     * @param $field
     *
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteRule();
        }
        return parent::load($id, $field);
    }

    /**
     * Load Assigned Rule Pos Category
     *
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function noRouteRule()
    {
        return $this->load(self::NOROUTE_ID, $this->getIdFieldName());
    }

    /**
     * Get identities.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG."_".$this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return parent::getData(self::ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

        /**
         * Get Loyalty Rule ID
         *
         * @return int|null
         */
    public function getLoyaltyRuleId()
    {
        return parent::getData(self::LOYALTY_RULE_ID);
    }

    /**
     * Set Loyalty Rule ID
     *
     * @param int $ruleId
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function setLoyaltyRuleId($ruleId)
    {
        return $this->setData(self::LOYALTY_RULE_ID, $ruleId);
    }

    /**
     * Get Category ID
     *
     * @return int|null
     */
    public function getCategoryId()
    {
        return parent::getData(self::CATEGORY_ID);
    }

    /**
     * Set Category ID
     *
     * @param int $categoryId
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function setCategoryId($categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * Get Loyalty Points
     *
     * @return int|null
     */
    public function getLoyaltyPoints()
    {
        return parent::getData(self::LOYALTY_POINTS);
    }

    /**
     * Set Loyalty Points
     *
     * @param int $loyaltypoints
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function setLoyaltyPoints($loyaltypoints)
    {
        return $this->setData(self::LOYALTY_POINTS, $loyaltypoints);
    }

    /**
     * Get Created Time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }

    /**
     * Set Created Time
     *
     * @param string $createdAt
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get Updated Time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return parent::getData(self::UPDATED_AT);
    }

    /**
     * Set Updated Time
     *
     * @param string $createdAt
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
