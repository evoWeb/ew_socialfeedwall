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

class DisplayController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var TwitterService
     */
    protected $twitterService;

    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    protected function initializeAction()
    {
        $this->settings = \Evoweb\EwSocialfeedwall\Utility\Configuration::mergeSettings($this->settings);
    }

    public function showAction()
    {
    }

    public function getTweetsAction(): string
    {
        $this->twitterService->setSettings($this->settings['twitter']);
        $statuses = $this->twitterService->getByRequest($this->request);

        $this->request->setFormat('json');
        return str_replace('\/', '/', \json_encode($statuses));
    }
}
