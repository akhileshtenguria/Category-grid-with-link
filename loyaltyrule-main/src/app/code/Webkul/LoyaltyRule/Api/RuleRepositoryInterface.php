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

namespace Webkul\LoyaltyRule\Api;

use Webkul\LoyaltyRule\Api\Data\RuleInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface RuleRepositoryInterface
{
    /**
     * Save Rule
     *
     * @param \Webkul\LoyaltyRule\Api\Data\RuleInterface $data
     *
     * @return void
     */
    public function save(RuleInterface $data);

    /**
     * Get Rule By Id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * Get List
     *
     * @param  \Magento\Framework\Api\SearchCriteriaInterfac $searchCriteria
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Rule Record
     *
     * @param \Webkul\LoyaltyRule\Api\Data\RuleInterface $data
     *
     * @return void
     */
    public function delete(RuleInterface $data);

    /**
     * Delete Rule Record By Id
     *
     * @param int
     *
     * @return void
     */
    public function deleteById($id);
}
