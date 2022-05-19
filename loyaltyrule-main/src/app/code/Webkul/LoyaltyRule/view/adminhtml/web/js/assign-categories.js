/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_LoyaltyRule
 * @author    Webkul
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

define([
    "mage/adminhtml/grid"
], function () {
    "use strict";
    return function (config) {
        var selectedCategory = config.selectedCategory,
        selectedCategory = $H(selectedCategory),
        gridJsObject = window[config.gridJsObjectName],
        tabIndex = 1000;
        $("selected_rule_category").value = Object.toJSON(selectedCategory);

        /**
         * Register Outlet Product
         *
         * @param {Object} grid
         * @param {Object} element
         * @param {Boolean} checked
         */
        function registerSelectedProduct(grid, element, checked)
        {
            if (checked) {
                if (element.positionElement) {
                    element.positionElement.disabled = false;
                    selectedCategory.set(element.value, element.positionElement.value);
                }
            } else {
                if (element.positionElement) {
                    element.positionElement.disabled = true;
                }
                selectedCategory.unset(element.value);
            }
            $("selected_rule_category").value = Object.toJSON(selectedCategory);
            grid.reloadParams = {
                "selected_category[]": selectedCategory.keys()
            };
        }

        /**
         * Click on product row
         *
         * @param {Object} grid
         * @param {String} event
         */
        function selectedProductRowClick(grid, event)
        {
            var trElement = Event.findElement(event, "tr"),
            isInput = Event.element(event).tagName === "INPUT",
            checked = false,
            checkbox = null;
            if (trElement) {
                checkbox = Element.getElementsBySelector(trElement, "input");
                if (checkbox[0]) {
                    checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
                    gridJsObject.setCheckboxChecked(checkbox[0], checked);
                }
            }
        }

        /**
         * Change product position
         *
         * @param {String} event
         */
        function positionChange(event)
        {
            var element = Event.element(event);
            if (element) {
                var qtyVal = parseInt(element.value);
                if (qtyVal <= 0) {
                    element.value = 1;
                }
            }
            if (element && element.checkboxElement && element.checkboxElement.checked) {
                selectedCategory.set(element.checkboxElement.value, element.value);
                $("selected_rule_category").value = Object.toJSON(selectedCategory);
            }
        }

        /**
         * Initialize Outlet product row
         *
         * @param {Object} grid
         * @param {String} row
         */
        function selectedProductRowInit(grid, row)
        {
            var checkbox = $(row).getElementsByClassName("checkbox")[0],
            position = $(row).getElementsByClassName("input-text")[0],
            tempSelectedProduct = JSON.parse(Object.toJSON(selectedCategory));
            if (typeof checkbox != "undefined") {
                if (typeof tempSelectedProduct[checkbox.value] != "undefined" 
                    && tempSelectedProduct[checkbox.value] != "") {
                    gridJsObject.setCheckboxChecked(checkbox, true);
                    position.value = tempSelectedProduct[checkbox.value];
                }
            }
            
            if (checkbox && position) {
                checkbox.positionElement = position;
                position.checkboxElement = checkbox;
    
                position.disabled = !checkbox.checked;
                position.tabIndex = tabIndex++;
                Event.observe(position, "keyup", positionChange);
            }
        }

        gridJsObject.rowClickCallback = selectedProductRowClick;
        gridJsObject.initRowCallback = selectedProductRowInit;
        gridJsObject.checkboxCheckCallback = registerSelectedProduct;
        if (gridJsObject.rows) {
            gridJsObject.rows.each(function (row) {
                selectedProductRowInit(gridJsObject, row);
            });
        }
    };
});
