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

namespace Webkul\LoyaltyRule\Block\Adminhtml\Rule\Edit;

use Webkul\LoyaltyRule\Block\Adminhtml\Rule\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        $outletId = $this->getRuleId();
        $data = [];
        if ($outletId) {
            $data = [
                "id" => "rule-edit-delete-button",
                "label" => __("Delete Rule"),
                "class" => "delete",
                "on_click" => "",
                "sort_order" => 20,
                "data_attribute" => ["url"=>$this->getDeleteUrl()]
            ];
        }
        return $data;
    }

    /**
     * Get Delete Url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl("*/*/delete", ["id" => $this->getRuleId()]);
    }
}
