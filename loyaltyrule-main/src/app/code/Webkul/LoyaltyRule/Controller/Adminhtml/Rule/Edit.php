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
 * class for the edit form of the loyalty rule.
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Webkul\LoyaltyRule\Model\RuleFactory
     */
    private $ruleFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * __construct
     *
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context,
        \Webkul\LoyaltyRule\Model\RuleFactory $ruleFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->ruleFactory  = $ruleFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Edit Action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $ruleId = $this->getRequest()->getParam("id");
        $model    = $this->ruleFactory->create();
        if ($ruleId) {
            $model->load($ruleId);
            if (!$model->getId()) {
                $this->messageManager->addError(__("This rule no longer exists."));
                $this->_redirect("*/*/");
                return;
            }
        }
        
        $this->coreRegistry->register("current_rule_id", $ruleId);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu("Webkul_LoyaltyRule::posloyalty");
        $resultPage->getConfig()->getTitle()->prepend(__("Loyalty Rule"));
        return $resultPage;
    }

    /**
     * Check if user has permissions to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed("Webkul_LoyaltyRule::posloyalty");
    }
}
