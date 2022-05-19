/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_LoyaltyRule
 * @author    Webkul
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

require(
    [
    "jquery",
    "Magento_Ui/js/modal/confirm",
    "mage/translate"
    ], function ($, confirm) {
        "use strict";
        function getRuleForm(url)
        {
            return $("<form>", {"action": url, "method": "POST"})
            .append(
                $(
                    "<input>", {
                        "name": "form_key",
                        "value": window.FORM_KEY,
                        "type": "hidden"
                    }
                )
            );
        }
        $("#rule-edit-delete-button").on(
            "click", function () {
                var confirmationMsg = $.mage.__("Are you sure you want to do this?");
                var deleteUrl = $("#rule-edit-delete-button").data("url");
                confirm(
                    {
                        "content": confirmationMsg,
                        "actions": {
                            confirm: function () {
                                getRuleForm(deleteUrl).appendTo("body").submit();
                            }
                        }
                    }
                );
                return false;
            }
        );
    }
);