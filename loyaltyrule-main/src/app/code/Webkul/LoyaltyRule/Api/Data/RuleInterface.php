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

interface RuleInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID                    = "id";
    const RULE_NAME             = "rule_name";
    const START_DATE            = "start_date";
    const END_DATE              = "end_date";
    const STATUS                = "status";
    const CREATED_AT            = "created_at";
    const UPDATED_AT            = "updated_at";

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
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setId($id);

    /**
     * Get Rule Name
     *
     * @return string|null
     */
    public function getRuleName();

    /**
     * Set Rule Name
     *
     * @param string $ruleName
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setRuleName($ruleName);

    /**
     * Get Start Date
     *
     * @return string|null
     */
    public function getStartDate();

    /**
     * Set Start Date
     *
     * @param string $startDate
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setStartDate($startDate);

    /**
     * Get End Date
     *
     * @return string|null
     */
    public function getEndDate();

    /**
     * Set End Date
     *
     * @param string $endDate
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setEndDate($endDate);

    /**
     * Get Rule Status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set Rule Status
     *
     * @param int $status
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setStatus($status);

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
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
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
     * @return \Webkul\LoyaltyRule\Api\Data\RuleInterface
     */
    public function setUpdatedAt($updatedAt);
}
