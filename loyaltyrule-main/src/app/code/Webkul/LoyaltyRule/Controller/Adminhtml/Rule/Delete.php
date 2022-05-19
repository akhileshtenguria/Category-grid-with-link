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
 * class for the delete action of the loyalty rule.
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Webkul\LoyaltyRule\Model\RuleFactory
     */
    private $ruleFactory;
    
    /**
     * __construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory
    ) {
        $this->ruleFactory = $ruleFactory;
        parent::__construct($context);
    }

    /**
     * Delete Action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $ruleId = (int) $this->getRequest()->getParam("id");
        if ($ruleId) {
            $ruleModel = $this->ruleFactory->create()->load($ruleId);
            if (!$ruleModel->getId()) {
                $this->messageManager->addError(__("This record no longer exists."));
            } else {
                try {
                    $ruleModel->delete();
                    $this->messageManager->addSuccess(__("The record has been deleted."));
                    $this->_redirect("*/*/");
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect("*/*/edit", ["id"=>$ruleModel->getId()]);
                }
            }
        }
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
