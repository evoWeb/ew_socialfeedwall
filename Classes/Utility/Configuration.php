<?php
namespace Evoweb\EwSocialfeedwall\Utility;

class Configuration
{
    /**
     * @param array $settings
     * @param array|null $configuration
     *
     * @return array
     */
    public static function mergeSettings(array $settings, $configuration = null)
    {
        if (is_null($configuration)) {
            $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ew_socialfeedwall']);
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
