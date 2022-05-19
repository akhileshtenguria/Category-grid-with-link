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

namespace Webkul\LoyaltyRule\Model\Config\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Get Status Type Options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ["value"=>1, "label"=>__("Enabled")],
            ["value"=>0, "label"=>__("Disabled")]
        ];
    }

    /**
     * Get Status Type Options
     *
     * @return array
     */
    public function toArray()
    {
        return [1=>__("Enabled"), 0=>__("Disabled")];
    }
}
