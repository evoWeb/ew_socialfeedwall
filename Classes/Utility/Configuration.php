<?php
namespace Evoweb\EwSocialfeedwall\Utility;

/**
 * Class Configuration
 *
 * Supported are
 *
 * TypoScript setup:
 * plugin.extension {
 *  settings {
 *   key1 = value2a
 *   key2 {
 *    subKey2 = value3a
 *   }
 *  }
 * }
 *
 * Override in Flexform:
 * settings.key1Override = value2b
 * settings.key2.subKey2Override = value3b
 *
 * Fallback in extension configuration:
 * key1 = value2
 * key2.subKey2 = value3
 */
class Configuration
{
    /**
     * @var string
     */
    protected static $extensionKey = 'ew_socialfeedwall';

    /**
     * @param array $settings
     * @param array|null $configuration
     *
     * @return array
     */
    public static function mergeSettings(array $settings, $configuration = null)
    {
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][self::$extensionKey])) {
            if (is_null($configuration)) {
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
