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
use Magento\Framework\Api\SearchCriteriaInterface;

class RuleRepository implements \Webkul\LoyaltyRule\Api\RuleRepositoryInterface
{
    /**
     * @var RuleInterface
     */
    protected $ruleFactory;

    /**
     * @var ResourceModel\Rule
     */
    protected $resourceModel;

    /**
     * @var ResourceModel\Rule\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var array
     */
    protected $instancesById = [];

    /**
     * Construct
     *
     * @param RuleInterface $ruleFactory
     * @param ResourceModel\Rule $resourceModel
     * @param ResourceModel\Rule\CollectionFactory $collectionFactory
     */
    public function __construct(
        RuleInterface $ruleFactory,
        ResourceModel\Rule $resourceModel,
        ResourceModel\Rule\CollectionFactory $collectionFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->ruleFactory = $ruleFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Save Rule
     *
     * @param \Webkul\LoyaltyRule\Api\Data\RuleInterface $data
     *
     * @return void
     */
    public function save(RuleInterface $rule)
    {
        $ruleId = $rule->getId();
        try {
            $this->resourceModel->save($rule);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException($e->getMessage());
        }
        unset($this->instancesById[$rule->getId()]);
        return $this->getById($rule->getId());
    }

    /**
     * Get Rule By Id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($ruleId)
    {
        $ruleData = $this->ruleFactory;
        $ruleData->load($ruleId);
        $this->instancesById[$ruleId] = $ruleData;
        return $this->instancesById[$ruleId];
    }

    /**
     * Get List
     *
     * @param  \Magento\Framework\Api\SearchCriteriaInterfac $searchCriteria
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $collection->load();
        return $collection;
    }

    /**
     * Delete Rule Record
     *
     * @param \Webkul\LoyaltyRule\Api\Data\RuleInterface $data
     *
     * @return void
     */
    public function delete(RuleInterface $rule)
    {
        $ruleId = $rule->getId();
        try {
            $this->resourceModel->delete($rule);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(__("Unable to remove rule with id %1", $ruleId));
        }
        unset($this->instancesById[$ruleId]);
        return true;
    }

    /**
     * Delete Rule Record By Id
     *
     * @param int
     *
     * @return void
     */
    public function deleteById($ruleId)
    {
        $rule = $this->getById($ruleId);
        return $this->delete($rule);
    }
}
