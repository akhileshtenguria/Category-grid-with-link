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

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [
            "label" => __("Save Rule"),
            "class" => "save primary",
            "sort_order"     => 90,
            "data_attribute" => [
                "mage-init"  => ["button"=>["event"=>"save"]],
                "form-role"  => "save",
            ]
        ];
        return $data;
    }
}
