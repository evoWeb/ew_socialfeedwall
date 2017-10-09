<?php
namespace Evoweb\EwSocialfeedwall\Service;

use TYPO3\CMS\Extbase\Object\ObjectManager;

class TwitterService
{
    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * TwitterService constructor.
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\Request $request
     *
     * @return array|object
     */
    public function getByRequest($request)
    {
        if ($request->hasArgument('since_id')) {
            return $this->getBySearchAndSinceId(
                $request->getArgument('search'),
                $request->getArgument('since_id')
            );
        } else {
            return $this->getBySearch(
                $request->getArgument('search')
            );
        }
    }

    /**
     * @param string $search
     *
     * @return array|object
     */
    public function getBySearch($search)
    {
        $parameter = [
            'q' => $search . ' -filter:retweets',
            'count' => $this->settings['limit'],
        ];

        return $this->queryTwitter($parameter);
    }

    /**
     * @param string $search
     * @param string $sinceId
     *
     * @return array|object
     */
    public function getBySearchAndSinceId($search, $sinceId)
    {
        $parameter = [
            'q' => $search . ' -filter:retweets',
            'count' => $this->settings['limit'],
            'since_id' => $sinceId,
        ];

        return $this->queryTwitter($parameter);
    }

    /**
     * @param array $parameter
     *
     * @return array
     */
    protected function queryTwitter($parameter)
    {
        /** @var \Abraham\TwitterOAuth\TwitterOAuth $connection */
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $connection = $this->objectManager->get(
            \Abraham\TwitterOAuth\TwitterOAuth::class,
            $this->settings['consumer_key'],
            $this->settings['consumer_secret'],
            $this->settings['access_token'],
            $this->settings['access_token_secret']
        );

        try {
            $response = $connection->get('search/tweets', $parameter);
            $result = $response->statuses;
        } catch (\Exception $exception) {
            $result = [];
        }

        return $result;
    }
}
