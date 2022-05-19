<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_LoyaltyRule
 * @author    Webkul <support@webkul.com>
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html ASL Licence
 * @link      https://store.webkul.com/license.html
 */

namespace Webkul\LoyaltyRule\Block\Adminhtml\Rule\Edit;

class GenericButton
{
    protected $registry;
    protected $urlBuilder;

    /**
     * __construct
     *
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->registry   = $registry;
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * Get Outlet Id
     *
     * @return int
     */
    public function getRuleId()
    {
        return $this->registry->registry("current_rule_id");
    }

    /**
     * Get Url
     *
     * @param  string $route
     * @param  array $params
     *
     * @return string
     */
    public function getUrl($route = "", $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
