<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_LoyaltyRule
 * @author    Webkul
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\LoyaltyRule\Api\Data;

interface RuleCategoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID              = "id";
    const LOYALTY_RULE_ID = "loyalty_rule_id";
    const CATEGORY_ID     = "category_id";
    const LOYALTY_POINTS  = "loyalty_points";
    const CREATED_AT      = "created_at";
    const UPDATED_AT      = "updated_at";

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Webkul\LoyaltyRule\Api\Data\PosCategoryInterface
     */
    public function setId($id);

    /**
     * Get Loyalty Rule ID
     *
     * @return int|null
     */
    public function getLoyaltyRuleId();

    /**
     * Set Loyalty Rule ID
     *
     * @param int $ruleId
     * @return \Webkul\LoyaltyRule\Api\Data\PosCategoryInterface
     */
    public function setLoyaltyRuleId($ruleId);

    /**
     * Get Category ID
     *
     * @return int|null
     */
    public function getCategoryId();

    /**
     * Set Category ID
     *
     * @param int $categoryId
     * @return \Webkul\LoyaltyRule\Api\Data\PosCategoryInterface
     */
    public function setCategoryId($categoryId);

    /**
     * Get Loyalty Points
     *
     * @return int|null
     */
    public function getLoyaltyPoints();

    /**
     * Set Loyalty Points
     *
     * @param int $loyaltypoints
     * @return \Webkul\LoyaltyRule\Api\Data\PosCategoryInterface
     */
    public function setLoyaltyPoints($loyaltypoints);

    /**
     * Get Created Time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set Created Time
     *
     * @param string $createdAt
     * @return \Webkul\LoyaltyRule\Api\Data\PosCategoryInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Updated Time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set Updated Time
     *
     * @param string $updatedAt
     * @return \Webkul\LoyaltyRule\Api\Data\PosCategoryInterface
     */
    public function setUpdatedAt($updatedAt);
}
