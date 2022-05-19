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

namespace Webkul\LoyaltyRule\Block\Adminhtml\Rule\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * class for the generic button of the loyalty rule grid.
 */
class Form extends Generic
{
    /**
     * function to prepare form.
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            ["data" =>
                [
                    "id"     => "edit_form",
                    "action" => $this->getData("action"),
                    "method" => "post"
                ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
