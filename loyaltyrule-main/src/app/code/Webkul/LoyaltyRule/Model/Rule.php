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

use Webkul\LoyaltyRule\Api\Data\RuleInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Rule extends AbstractModel implements RuleInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    const NOROUTE_ID = "no-route";

    /**
     * Pos Loyalty Rules cache tag.
     */
    const CACHE_TAG = "loyalty_rules";

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'loyalty_rules';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Webkul\LoyaltyRule\Model\ResourceModel\Rule::class);
    }

    /**
     * Load Loyalty Rule Record
     *
     * @param int $status
     * @param $field
     *
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteRule();
        }
        return parent::load($id, $field);
    }

    /**
     * Load Loyalty Rule Record
     *
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
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
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get Rule Name
     *
     * @return string|null
     */
    public function getRuleName()
    {
        return parent::getData(self::RULE_NAME);
    }

    /**
     * Set Rule Name
     *
     * @param string $ruleName
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setRuleName($ruleName)
    {
        return $this->setData(self::RULE_NAME, $ruleName);
    }

    /**
     * Get Redeem Type
     *
     * @return int|null
     */
    public function getRedeemType()
    {
        return parent::getData(self::REDEEM_TYPE);
    }

    /**
     * Set Redeem Type
     *
     * @param int $redeemType
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setRedeemType($redeemType)
    {
        return $this->setData(self::REDEEM_TYPE, $redeemType);
    }

    /**
     * Get Start Date
     *
     * @return string|null
     */
    public function getStartDate()
    {
        return parent::getData(self::START_DATE);
    }

    /**
     * Set Start Date
     *
     * @param string $startDate
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setStartDate($startDate)
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * Get End Date
     *
     * @return string|null
     */
    public function getEndDate()
    {
        return parent::getData(self::END_DATE);
    }

    /**
     * Set End Date
     *
     * @param string $endDate
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setEndDate($endDate)
    {
        return $this->setData(self::END_DATE, $endDate);
    }

    /**
     * Get Rule Status
     *
     * @return int|null
     */
    public function getStatus()
    {
        return parent::getData(self::STATUS);
    }

    /**
     * Set Rule Status
     *
     * @param int $status
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get Selected Redemption Rules
     *
     * @return string|null
     */
    public function getSelectedRedeemRule()
    {
        return parent::getData(self::SELECTED_REDEEM_RULE);
    }

    /**
     * Set Selected Redemption Rules
     *
     * @param string $selectedRedeemRule
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setSelectedRedeemRule($selectedRedeemRule)
    {
        return $this->setData(self::SELECTED_REDEEM_RULE, $selectedRedeemRule);
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
     * @param string $updatedAt
     * @return \Webkul\LoyaltyRule\Api\Data\RuleCategoryInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
