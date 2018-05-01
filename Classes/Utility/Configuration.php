<?php
namespace Evoweb\EwSocialfeedwall\Utility;

/**
 * This file is developed by evoweb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

class Configuration
{
    /**
     * @var string
     */
    protected static $extensionKey = 'ew_socialfeedwall';

    public static function mergeSettings(array $settings, array $configuration = null): array
    {
        if (is_null($configuration)) {
            if (class_exists(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)) {
                $configuration = (bool)\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
                )->get(self::$extensionKey);
            } else {
                $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][self::$extensionKey]);
            }
        } else {
            $configuration = [];
        }

        // iterate over the array
        array_walk($settings, function (&$value, $key) use (&$settings, $configuration) {
            // get override key
            $overrideKey = $key . 'Override';

            // recursive use if is array
            if (is_array($value)) {
                $value = Configuration::mergeSettings(
                    $value,
                    // get nested configuration
                    (isset($configuration[$key . '.']) ? $configuration[$key . '.'] : [])
                );
                // for non array value check if override exist
            } elseif (isset($settings[$overrideKey])) {
                // if override is not empty use it
                if (!empty($settings[$overrideKey])) {
                    $value = $settings[$overrideKey];
                }

                // remove override
                unset($settings[$overrideKey]);
            }

            // if value is empty but fallback configuration exists
            if (empty($value) && isset($configuration[$key])) {
                $value = $configuration[$key];
            }
        });

        return $settings;
    }
}
