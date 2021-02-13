<?php

namespace Evoweb\EwSocialfeedwall\Service;

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

class TwitterService
{
    protected array $settings = [];

    public function setSettings(array $settings)
    {
        $this->settings = $settings;
    }

    public function getByRequest(\TYPO3\CMS\Extbase\Mvc\Request $request): array
    {
        if ($request->hasArgument('since_id')) {
            return $this->getBySearchAndSinceId(
                $request->getArgument('search'),
                (int) $request->getArgument('since_id')
            );
        } else {
            return $this->getBySearch(
                $request->getArgument('search')
            );
        }
    }

    public function getBySearch(string $search): array
    {
        $parameter = [
            'q' => $search . ' -filter:retweets',
            'count' => $this->settings['limit'],
        ];

        return $this->queryTwitter($parameter);
    }

    public function getBySearchAndSinceId(string $search, int $sinceId): array
    {
        $parameter = [
            'q' => $search . ' -filter:retweets',
            'count' => $this->settings['limit'],
            'since_id' => $sinceId,
        ];

        return $this->queryTwitter($parameter);
    }

    protected function queryTwitter(array $parameter): array
    {
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth(
            '',
            '',
            '',
            $this->settings['twitter']['bearer_token']
        );

        try {
            $response = $connection->get('search/tweets', $parameter);
            if (isset($response->errors) && !empty($response->errors)) {
                $result = [];
            } else {
                $result = $response->statuses;
            }
        } catch (\Exception $exception) {
            $result = [];
        }

        return $result;
    }
}
