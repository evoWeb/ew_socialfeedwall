<?php

namespace Evoweb\EwSocialfeedwall\Utility;

/*
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

class Configuration
{
    protected static string $extensionKey = 'ew_socialfeedwall';

    protected ExtensionConfiguration $extensionConfiguration;

    public function __construct(ExtensionConfiguration $extensionConfiguration)
    {
        $this->extensionConfiguration = $extensionConfiguration;
    }

    public function mergeSettings(array $settings, array $configuration = []): array
    {
        if (empty($configuration) || !is_array($configuration)) {
            try {
                $configuration = $this->extensionConfiguration->get(self::$extensionKey);
            } catch (\Exception $e) {
                $configuration = [];
            }
        }

        // iterate over the array
        array_walk($settings, function (&$value, $key) use (&$settings, $configuration) {
            // get override key
            $overrideKey = $key . 'Override';

            // recursive use if is array
            if (is_array($value)) {
                $value = $this->mergeSettings(
                    $value,
                    // get nested configuration
                    $configuration[$key] ?? []
                );
            // for non array value check if override exist
            } elseif (isset($settings[$overrideKey])) {
                // if override is not empty use it
                if (!empty($settings[$overrideKey])) {
                    $value = $settings[$overrideKey];
                }
            }

            // if value is empty but fallback configuration exists
            if (empty($value) && isset($configuration[$key])) {
                $value = $configuration[$key];
            }

            // remove override
            unset($settings[$overrideKey]);
        });

        return $settings;
    }
}
