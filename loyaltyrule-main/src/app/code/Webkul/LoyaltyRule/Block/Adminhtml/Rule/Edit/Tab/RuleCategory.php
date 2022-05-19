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

namespace Webkul\LoyaltyRule\Block\Adminhtml\Rule\Edit\Tab;

/**
 * class for the pos category tab for the rule grid.
 */
class RuleCategory extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Framework\View\Element\BlockInterface
     */
    protected $blockGrid;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory
     */
    protected $ruleCategoryCollection;

    /**
     * @var string
     */
    protected $_template = "category/rule_category.phtml";

    /**
     * Construct
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Backend\Block\Template\Context $context,
        \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection,
        array $data = []
    ) {
        $this->request = $request;
        $this->jsonHelper = $jsonHelper;
        $this->ruleCategoryCollection = $ruleCategoryCollection;
        parent::__construct($context, $data);
    }

    /**
     * get selected category data
     *
     * @return json
     */
    public function getSelectedCategoryData()
    {
        $data = [];
        $ruleId = $this->request->getParam("id");
        $pointsCollection = $this->ruleCategoryCollection->create()
            ->addFieldToFilter("loyalty_rule_id", $ruleId);
        
        foreach ($pointsCollection as $each) {
            $data[$each->getCategoryId()] = $each->getLoyaltyPoints();
        }
        if (!empty($data)) {
            return $this->jsonHelper->jsonEncode($data);
        } else {
            return "{}";
        }
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                \Webkul\LoyaltyRule\Block\Adminhtml\Rule\Edit\Tab\CategoryGrid::class,
                "loyalty.rule.categorygrid"
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }
}
