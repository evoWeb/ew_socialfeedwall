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
        $twitterConfiguration = $this->settings['twitter'];

        $parameter = [
            'q' => $this->request->getArgument('search'),
            'count' => $this->settings['limit'],
            'exclude_replies' => true,
        ];

        if ($this->request->hasArgument('since_id')) {
            $parameter['since_id'] = $this->request->getArgument('since_id');
        }

        /** @var \Abraham\TwitterOAuth\TwitterOAuth $connection */
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $connection = $this->objectManager->get(
            \Abraham\TwitterOAuth\TwitterOAuth::class,
            $twitterConfiguration['consumer_key'],
            $twitterConfiguration['consumer_secret'],
            $twitterConfiguration['access_token'],
            $twitterConfiguration['access_token_secret']
        );

        $statuses = $connection->get('search/tweets', $parameter);

        $this->request->setFormat('json');
        $jsonResult = str_replace('\/', '/', \GuzzleHttp\json_encode($statuses->statuses));
        return $jsonResult;
    }
}
