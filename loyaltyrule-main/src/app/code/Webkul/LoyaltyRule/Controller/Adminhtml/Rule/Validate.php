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
 * class for the validation of the redeemrules data.
 */
class Validate extends \Magento\Backend\App\Action
{
    /**
     * @var \Webkul\LoyaltyRule\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Framework\DataObject
     */
    private $response;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $jsonHelper;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory
     */
    private $ruleCategoryCollection;

    /**
     * @var string
     */
    private $message = "";
    
    /**
     * Construct
     *
     * @param \Magento\Framework\DataObject $response
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection
     */
    public function __construct(
        \Magento\Framework\DataObject $response,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection
    ) {
        $this->response                 = $response;
        $this->jsonHelper               = $jsonHelper;
        $this->resultJsonFactory        = $resultJsonFactory;
        $this->ruleCategoryCollection   = $ruleCategoryCollection;
        parent::__construct($context);
    }

    /**
     * Validate Rule Request Data
     *
     * @param \Magento\Framework\DataObject $response
     *
     * @return $this
     */
    private function _validateRule($response)
    {
        $errors = [];
        try {
            $formData    = $this->getRequest()->getPostValue("loyalty_rule");
            $ruleId      = $formData["id"] ?? 0;

            $title       = $formData["rule_name"] ?? "";
            $illegalChar = "#$%^&*()+=-[]';,./{}|:<>?~";
            $isValid     = (false === strpbrk($title, $illegalChar)) ? true : false;
                
            if (!$isValid) {
                $errors[] = __("Special symbols are not allowed in rule name.");
            }
            
            if (isset($formData["id"])) {
                $posCategory = $this->getRuleCategory($response, $formData["id"]);
                if (!isset($formData["selected_rule_category"])) {
                    $formData["selected_rule_category"] = $posCategory;
                }
            }
                
            if (isset($formData["start_date"]) && isset($formData["end_date"])) {
                $start = strtotime($formData["start_date"]);
                $end   = strtotime($formData["end_date"]);
                
                if ($start >= $end) {
                    $errors[] = __("End Date must be greater than Start Date.");
                }
            }

            $this->_getSession()->setFormData($formData);
            if ($ruleId != 0) {
                $this->_redirect("*/*/edit", ["id"=>$ruleId]);
            }
        } catch (\Magento\Framework\Validator\Exception $exception) {
            $exceptionMsg = $exception->getMessages(\Magento\Framework\Message\MessageInterface::TYPE_ERROR);
            foreach ($exceptionMsg as $error) {
                $errors[] = $error->getText();
            }
        }
        $this->setErrorMessages($errors, $response);
       
        return $this;
    }

    /**
     * Set Error Messages in \Magento\Framework\DataObject $response
     *
     * @param array $errors
     * @param \Magento\Framework\DataObject $response
     *
     * @return void
     */
    private function setErrorMessages($errors, $response)
    {
        if (!empty($errors)) {
            $messages = $response->hasMessages() ? $response->getMessages() : [];
            foreach ($errors as $error) {
                $messages[] = $error;
            }
            $response->setMessages($messages);
            $response->setError(1);
        }
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = $this->response;
        $response->setError(0);

        $isPost = $this->getRequest()->getPost();
        if ($isPost) {
            $this->_validateRule($response);
        }

        $resultJson = $this->resultJsonFactory->create();
        if ($response->getError()) {
            $response->setError(true);
            $response->setMessages($response->getMessages());
        }
        $resultJson->setData($response);
        return $resultJson;
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

    /**
     * Get Pos Category
     *
     * @param int $ruleId
     * @param \Magento\Framework\DataObject $response
     *
     * @return string
     */
    private function getRuleCategory($response, $ruleId = 0)
    {
        $posCategory = "{}";
        try {
            if ($ruleId) {
                $pointsCollection = $this->ruleCategoryCollection->create()
                    ->addFieldToFilter("loyalty_rule_id", $ruleId);
                $categoryIdsWithPoints = [];
                foreach ($pointsCollection as $each) {
                    $awardedPoint = $each->getLoyaltyPoints();
                    $categoryIdsWithPoints[$each->getCategoryId()] = $awardedPoint;
                }
                $posCategory = $this->jsonHelper->jsonEncode($categoryIdsWithPoints);
            }
        } catch (\Exception $e) {
            $error = [];
            $error[] = $e->getMessage();
            $this->setErrorMessages($error, $response);
        }
        
        return $posCategory;
    }
}
