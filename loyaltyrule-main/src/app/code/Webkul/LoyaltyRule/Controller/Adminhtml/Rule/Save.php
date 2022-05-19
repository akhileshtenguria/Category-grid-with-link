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

namespace Webkul\LoyaltyRule\Controller\Adminhtml\Rule;

/**
 * class for the save action of the loyalty rules.
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resource;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $jsonHelper;

    /**
     * @var \Webkul\LoyaltyRule\Model\RuleFactory
     */
    private $ruleFactory;

    /**
     * @var \Webkul\LoyaltyRule\Model\RuleCategoryFactory
     */
    private $ruleCategoryFactory;

    /**
     * @var \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory
     */
    private $ruleCategoryCollection;

    /**
     * @var \Webkul\LoyaltyRule\Helper\Data
     */
    private $helper;
   
    /**
     * Construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory
     * @param \Webkul\LoyaltyRule\Model\RuleCategoryFactory $ruleCategoryFactory
     * @param \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\App\ResourceConnection $resource,
        \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory,
        \Webkul\LoyaltyRule\Model\RuleCategoryFactory $ruleCategoryFactory,
        \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection
    ) {
        $this->resource                 = $resource;
        $this->jsonHelper               = $jsonHelper;
        $this->ruleFactory              = $ruleFactory;
        $this->ruleCategoryFactory      = $ruleCategoryFactory;
        $this->ruleCategoryCollection   = $ruleCategoryCollection;
        parent::__construct($context);
    }

    /**
     * Execute Save Rule Action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();
        
        if ($isPost) {
            $ruleModel     = $this->ruleFactory->create();
            $formData      = $this->getRequest()->getPostValue("loyalty_rule");
            $ruleId        = $formData["id"] ?? 0;
           
            $title       = $formData["rule_name"] ?? "";
            $illegalChar = "#$%^&*()+=-[]';,./{}|:<>?~";
            $isValid     = (false === strpbrk($title, $illegalChar)) ? true : false;
                
            if (!$isValid) {
                $this->messageManager->addError(__("Special symbols are not allowed in rule name."));
                $this->_getSession()->setFormData($formData);
                if ($ruleId) {
                    $this->_redirect("*/*/edit", ["id"=>$ruleId]);
                } else {
                    $this->_redirect("*/*/new");
                }
                return;
            }
            
            if (isset($formData["start_date"]) && isset($formData["end_date"])) {
                $start = strtotime($formData["start_date"]);
                $end   = strtotime($formData["end_date"]);
                
                if ($start >= $end) {
                    $this->messageManager->addError(__("End Date must be greater than Start Date."));
                    $this->_getSession()->setFormData($formData);
                    if ($ruleId) {
                        $this->_redirect("*/*/edit", ["id"=>$ruleId]);
                    } else {
                        $this->_redirect("*/*/new");
                    }
                    return;
                }
            }

            if ($ruleId) {
                $ruleModel->load($ruleId);
            }
            
            $ruleModel->setData($formData);
            try {
                $ruleId = $ruleModel->save()->getId();
               
                // setting up selected category data ////////////////////////////////////////////////////////
                $selectedCategories = $formData["selected_rule_category"] ?? "";
               
                $this->saveRuleCategoryData($selectedCategories, $ruleId);

                $this->messageManager->addSuccess(__("The rule has been saved."));
                
                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", ["id"=>$ruleModel->getId(), "_current"=>true]);
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
            $this->_getSession()->setFormData($formData);
            $this->_redirect("*/*/edit", ["id"=>$ruleId]);
        }
    }

    /**
     * Delete Pos Category
     *
     * @param \Webkul\LoyaltyRule\Model\RuleCategory $ruleCategory
     *
     * @return void
     */
    private function deleteRuleCategory($ruleCategory)
    {
        $ruleCategory->delete();
    }

    /**
     * Save Pos Category
     *
     * @param int $assignedCategoryId
     * @param int $ruleId
     * @param int $loyaltyPoints
     * @param int $categoryId
     *
     * @return void
     */
    private function saveRuleCategory($assignedCategoryId, $ruleId, $loyaltyPoints, $categoryId = 0)
    {
        if ($categoryId != 0) {
            $this->ruleCategoryFactory->create()
                ->setCategoryId($assignedCategoryId)
                ->setLoyaltyRuleId($ruleId)
                ->setLoyaltyPoints($loyaltyPoints)
                ->setId($categoryId)
                ->save();
        } else {
            $this->ruleCategoryFactory->create()
                ->setCategoryId($assignedCategoryId)
                ->setLoyaltyRuleId($ruleId)
                ->setLoyaltyPoints($loyaltyPoints)
                ->save();
        }
    }
    
    /**
     * Save Pos Category Data
     *
     * @param string $selectedCategories
     * @param int $ruleId
     *
     * @return void
     */
    private function saveRuleCategoryData($selectedCategories, $ruleId)
    {
        if ($selectedCategories) {
            $loyaltyPoints = $this->jsonHelper->jsonDecode($selectedCategories);
            $collection  = $this->ruleCategoryCollection->create()->addFieldToFilter("loyalty_rule_id", $ruleId);
            foreach ($collection as $each) {
                $cond = in_array($each->getCategoryId(), array_keys($loyaltyPoints));
                if ($cond) {
                    $points = $loyaltyPoints[$each->getCategoryId()] ?? 0;
                    $this->saveRuleCategory($each->getCategoryId(), $ruleId, $points, $each->getId());
                    unset($loyaltyPoints[$each->getCategoryId()]);
                } else {
                    $this->deleteRuleCategory($each);
                }
            }
            foreach (array_keys($loyaltyPoints) as $categoryId) {
                $points = $loyaltyPoints[$categoryId] ?? 0;
                $ruleCategory = $this->ruleCategoryCollection->create()
                    ->addFieldToFilter("loyalty_rule_id", $ruleId)
                    ->addFieldToFilter("category_id", $categoryId)
                    ->getFirstItem();
                if ($ruleCategory) {
                    $this->deleteRuleCategory($ruleCategory);
                }
                $this->saveRuleCategory($categoryId, $ruleId, $points);
            }
        }
    }
}
