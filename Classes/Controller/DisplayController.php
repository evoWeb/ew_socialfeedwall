<?php
namespace Evoweb\EwSocialfeedwall\Controller;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class DisplayController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected function initializeAction()
    {
        if (isset($this->settings['searchOverride']) && !empty($this->settings['searchOverride'])) {
            $this->settings['search'] = $this->settings['searchOverride'];
        }

        $this->addResources();
    }

    protected function addResources()
    {
        $configuration = $this->configurationManager
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK)['view'];

        if (empty($configuration)) {
            return;
        }

        /** @var PageRenderer $pageRenderer */
        $pageRenderer = $this->objectManager->get(PageRenderer::class);

        if (isset($configuration['cssFiles']) && is_array($configuration['cssFiles'])) {
            array_walk($configuration['cssFiles'], function ($value) use ($pageRenderer) {
                $pageRenderer->addCssFile($value);
            });
        }
        if (isset($configuration['jsFooterFiles']) && is_array($configuration['jsFooterFiles'])) {
            array_walk($configuration['jsFooterFiles'], function ($value) use ($pageRenderer) {
                $pageRenderer->addJsFooterFile($value);
            });
        }
        if (isset($configuration['jsFooterLibraries']) && is_array($configuration['jsFooterLibraries'])) {
            array_walk($configuration['jsFooterLibraries'], function ($value, $key) use ($pageRenderer) {
                $pageRenderer->addJsFooterLibrary($key, $value);
            });
        }
    }

    public function showAction()
    {
    }

    public function getTweetsAction()
    {
        #use \Abraham\TwitterOAuth\TwitterOAuth;
    }
}
