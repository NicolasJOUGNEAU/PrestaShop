<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\PrestaShop\Adapter\Form\ChoiceProvider;

use PrestaShop\PrestaShop\Core\Form\FormChoiceAttributeProviderInterface;
use PrestaShop\PrestaShop\Core\Form\FormChoiceProviderInterface;
use TaxRulesGroup;

/**
 * Provides tax rule group choices with tax rule name as key and id as value
 */
final class TaxRuleGroupChoiceProvider implements FormChoiceProviderInterface, FormChoiceAttributeProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getChoices()
    {
        $choices = [];
        foreach ($this->getRules() as $rule) {
            $choices[$rule['name']] = (int) $rule['id_tax_rules_group'];
        }

        return $choices;
    }

    /**
     * {@inheritdoc}
     */
    public function getChoicesAttributes(): array
    {
        $attrs = [];
        foreach ($this->getRules() as $rule) {
            // Keep first one found
            if (!empty($attrs[$rule['name']]['data-tax-rate'])) {
                continue;
            }

            $attrs[$rule['name']] = [
                'data-tax-rate' => !empty($rule['rate']) ? $rule['rate'] : null,
            ];
        }

        return $attrs;
    }

    /**
     * @return array
     */
    private function getRules(): array
    {
        return TaxRulesGroup::getTaxRulesGroupsForOptions();
    }
}
