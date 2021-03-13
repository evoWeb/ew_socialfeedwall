<?php

namespace Evoweb\EwSocialfeedwall\Controller;

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

use Evoweb\EwSocialfeedwall\Service\TwitterService;
use Evoweb\EwSocialfeedwall\Utility\Configuration;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class DisplayController extends ActionController
{
    protected TwitterService $twitterService;

    protected Configuration $configuration;

    public function __construct(TwitterService $twitterService, Configuration $configuration)
    {
        $this->twitterService = $twitterService;
        $this->configuration = $configuration;
    }

    protected function initializeAction()
    {
        $this->settings = $this->configuration->mergeSettings($this->settings);
    }

    public function showAction(): ResponseInterface
    {
        return new HtmlResponse($this->view->render());
    }

    public function getTweetsAction(): ResponseInterface
    {
        $this->twitterService->setSettings($this->settings);
        $statuses = $this->twitterService->getByRequest($this->request);
        return new JsonResponse($statuses);
    }
}
