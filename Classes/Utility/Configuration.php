<?php
namespace Evoweb\EwSocialfeedwall\Utility;

class Configuration
{
    /**
     * @var array
     */
    protected $extensionConfiguration = [];

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ew_socialfeedwall']);
    }

    /**
     * @param array $settings
     * @param array|null $configuration
     *
     * @return array
     */
    public function mergeSettings(array $settings, $configuration = null)
    {
        if (is_null($configuration)) {
            $configuration = $this->extensionConfiguration;
        }

        $utility = $this;
        // iterate over the array
        array_walk($settings, function (&$value, $key) use ($utility, &$settings, $configuration) {
            // get override key
            $overrideKey = $key . 'Override';
            // recursive use if is array
            if (is_array($value)) {
                $value = $utility->mergeSettings(
                    $value,
                    // get nested configuration
                    (isset($configuration[$key . '.']) ? $configuration[$key . '.'] : [])
                );
            } elseif (isset($settings[$overrideKey])) {
                if (!empty($settings[$overrideKey])) {
                    $value = $settings[$overrideKey];
                }
                unset($settings[$overrideKey]);
            }

            if (empty($value) && isset($configuration[$key])) {
                $value = $configuration[$key];
            }
        });

        return $settings;
    }
}
