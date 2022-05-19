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

namespace Webkul\LoyaltyRule\Block\Adminhtml;

/**
 * class for the points input field of the category tab.
 */
class Points extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Input
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;
    
    /**
     * construct
     *
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->request = $request;
    }

    /**
     * render column
     *
     * @param  \Magento\Framework\DataObject $row
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $outletId    = $this->request->getParam("id");
        $assignedQty = $max = 0;
       
        $html  = '<input data-id="'.$row->getId().'" type="number" min="1" max="'.$max.'"';
        $html .= 'name="' . $this->getColumn()->getId() . '['.$row->getId().']" ';
        $html .= 'value="'.$assignedQty.'" ';
        $html .= 'class="'.$row->getTypeId().' input-text ' . $this->getColumn()->getClass();
        $html .= '" style="width:100px;min-width:100px;max-width:100px" />';
        return $html;
    }
}
