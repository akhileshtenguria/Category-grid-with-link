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

use Magento\Customer\Controller\RegistryConstants;

/**
 * class for the category grid tab in the rule form.
 */
class CategoryGrid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory
     */
    protected $ruleCategoryCollection;

    /**
     * Construct
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Webkul\LoyaltyRule\Model\ResourceModel\RuleCategory\CollectionFactory $ruleCategoryCollection,
        array $data = []
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->ruleCategoryCollection = $ruleCategoryCollection;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('loyalty_rule_categorygrid');
        $this->setDefaultSort('entity_id', 'asc');
        $this->setUseAjax(true);
    }

    /**
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        if ($column->getId() == 'in_categories') {
            $categoryIds = $this->_getSelectedCategories();
            if (empty($categoryIds)) {
                $categoryIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $categoryIds]);
            } elseif (!empty($categoryIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $categoryIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Apply various selection filters to prepare the category grid collection.
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->categoryFactory->create()
            ->getCollection()
            ->addAttributeToSelect('*');
        
        $collection->getSelect()
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns(['entity_id', 'e.children_count as childrenCount']);
       
        $collection->addAttributeToSelect('*')
            ->addFieldToFilter('name', ["neq"=>null])
            ->addFieldToFilter('is_active', 1);
            
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @inheritdoc
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            "entity_id",
            [
                "type"     => "number",
                "align"    => "center",
                "width"    => "30px",
                "index"    => "entity_id",
                "header"   => __("ID")
            ]
        );

        $this->addColumn(
            "name",
            [
                "index"    => "name",
                "align"    => "left",
                "header"   => __("Category Name")
            ]
        );

        $this->addColumn(
            "in_categories",
            [
                "type"     => "checkbox",
                "name"     => "in_categories",
                "align"    => "center",
                "width"    => "100px",
                "index"    => "entity_id",
                "values"   => $this->_getSelectedCategories(),
                "header"   => __("Select"),
                "sortable" => false
            ]
        );

        $this->addColumn(
            "inv",
            [
                "type"     => "input",
                "class"    => "number_check loyalty_points",
                "width"    => "150px",
                "align"    => "center",
                "index"    => "inv",
                "filter"   => false,
                "header"   => __("Loyalty Points"),
                "sortable" => false,
                "renderer" => \Webkul\LoyaltyRule\Block\Adminhtml\Points::class
            ]
        );
        
        return parent::_prepareColumns();
    }

    /**
     * @inheritdoc
     */
    public function getGridUrl()
    {
        return $this->getUrl("*/*/categoryGridData", ["_current"=>true]);
    }

    /**
     * @return array
     */
    protected function _getSelectedCategories()
    {
        $categoryIds = [];
        $ruleId      = $this->getRequest()->getParam("id");
        $pointsCollection = $this->ruleCategoryCollection->create()
            ->addFieldToFilter("loyalty_rule_id", $ruleId);
        
        foreach ($pointsCollection as $each) {
            $categoryIds[] = $each->getCategoryId();
        }
        return $categoryIds;
    }
}
