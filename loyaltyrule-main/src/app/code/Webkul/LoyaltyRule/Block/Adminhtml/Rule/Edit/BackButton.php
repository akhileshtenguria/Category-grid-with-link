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

class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            "label"      => __("Back to List"),
            "class"      => "back",
            "on_click"   => sprintf("location.href='%s';", $this->getBackUrl()),
            "sort_order" => 10
        ];
    }

    /**
     * Get Back Url
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl("*/*/");
    }
}
