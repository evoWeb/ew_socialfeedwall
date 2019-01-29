<?php
namespace Evoweb\EwSocialfeedwall\Controller;

/**
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
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

    public function getTweetsAction(): string
    {
        /** @var \Evoweb\EwSocialfeedwall\Service\TwitterService $twitterService */
        $twitterService = $this->objectManager->get(
            \Evoweb\EwSocialfeedwall\Service\TwitterService::class,
            $this->settings['twitter']
        );

        $statuses = $twitterService->getByRequest($this->request);

        $this->request->setFormat('json');
        return str_replace('\/', '/', \json_encode($statuses));
    }
}
