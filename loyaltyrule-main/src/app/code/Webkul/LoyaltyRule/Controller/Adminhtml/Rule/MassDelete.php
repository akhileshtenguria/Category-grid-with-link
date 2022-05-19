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
 * class for the mass delete of the loyalty rules.
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    private $filter;

    /**
     * @var \Webkul\LoyaltyRule\Model\RuleFactory
     */
    private $ruleFactory;

    /**
     * @var \Webkul\LoyaltyRule\Model\ResourceModel\Rule\CollectionFactory
     */
    private $collectionFactory;
    
    /**
     * __construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory
     * @param \Webkul\LoyaltyRule\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory,
        \Webkul\LoyaltyRule\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->ruleFactory = $ruleFactory;
        $this->collectionFactory = $collectionFactory;
       
        parent::__construct($context);
    }

    /**
     * function to perform the Mass Deletetion.
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $ruleDeleted = 0;
        foreach ($collection->getAllIds() as $ruleId) {
            if (!empty($ruleId)) {
                try {
                    $ruleModel = $this->ruleFactory->create();
                    $this->deleteRule($ruleModel, $ruleId);
                    $ruleDeleted++;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            }
        }
        if ($ruleDeleted) {
            $this->messageManager->addSuccess(__("A total of %1 record(s) were deleted.", $ruleDeleted));
        }
        $this->_redirect("*/*/index");
    }
    
    /**
     * function to delete Rule.
     *
     * @param  \Webkul\PosLoyaltyRule\Model\ResourceModel\Rule $ruleModel
     * @param  int $ruleId
     *
     * @return void
     */
    private function deleteRule($ruleModel, $ruleId)
    {
        $ruleModel->load($ruleId)->delete();
    }
    
    /**
     * Check if user has permissions to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed("Webkul_LoyaltyRule::loyalty");
    }
}
