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

namespace Webkul\LoyaltyRule\Block\Adminhtml\Rule;

/**
 * class for the edit form of the loaylty rule.
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * construct
     *
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data = []
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize form.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId   = "id";
        $this->_blockGroup = "Webkul_LoyaltyRule";
        $this->_controller = "adminhtml_rule";
        parent::_construct();
        $this->buttonList->remove("reset");
        $this->buttonList->update("save", "label", __("Save"));
        $this->buttonList->add(
            "saveandcontinue",
            [
                "label" => __("Save and Continue Edit"),
                "class" => "save",
                "data_attribute" => [
                    "mage-init"  => [
                        "button" => [
                            "event"  => "saveAndContinueEdit",
                            "target" => "#edit_form"
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update("delete", "label", __("Delete"));
    }

    /**
     * fucntion to get the header text.
     *
     * @return string
     */
    public function getHeaderText()
    {
        $ruleRegistry = $this->coreRegistry->registry("rule");
        if ($ruleRegistry->getId()) {
            $name = $this->escapeHtml($ruleRegistry->getRuleName());
            return __("Edit '%1'", $name);
        } else {
            return __("Add Loyalty Rule");
        }
    }

    /**
     * fucntion to create form block.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('post_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'post_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'post_content');
                }
            };
        ";
        return parent::_prepareLayout();
    }
}
