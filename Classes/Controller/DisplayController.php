<?php
namespace Evoweb\EwSocialfeedwall\Controller;

/**
 * Class DisplayController
 */
class DisplayController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected function initializeAction()
    {
        $this->settings = \Evoweb\EwSocialfeedwall\Utility\Configuration::mergeSettings($this->settings);

        $this->addResources();
    }

    protected function addResources()
    {
        $configuration = $this->configurationManager
            ->getConfiguration(
                \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
            )['view'];

        if (empty($configuration)) {
            return;
        }

        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
        $pageRenderer = $this->objectManager->get(\TYPO3\CMS\Core\Page\PageRenderer::class);

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
        /** @var \Evoweb\EwSocialfeedwall\Service\TwitterService $twitterService */
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $twitterService = $this->objectManager->get(
            \Evoweb\EwSocialfeedwall\Service\TwitterService::class,
            $this->settings['twitter']
        );

        $statuses = $twitterService->getByRequest($this->request);

        $this->request->setFormat('json');
        return str_replace('\/', '/', \json_encode($statuses));
    }
}
