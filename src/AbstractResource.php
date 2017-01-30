<?php namespace KlarnaCore;

use KlarnaCore\Exception\InvalidEnvironmentException;

abstract class Resource
{
    const ENVIRONMENT_LIVE_NA       = 'live_na';
    const ENVIRONMENT_LIVE_EU       = 'live_eu';
    const ENVIRONMENT_PLAYGROUND_NA = 'playground_na';
    const ENVIRONMENT_PLAYGROUND_EU = 'playground_eu';

    protected $mid;
    protected $secret;
    protected $environment;

    protected $client;

    /**
     * Resource constructor.
     *
     * @param string $mid
     * @param string $secret
     * @param string $environment
     * @param array  $clientOptions
     */
    public function __construct($mid, $secret, $environment = self::ENVIRONMENT_PLAYGROUND_NA, array $clientOptions = [])
    {
        $this->mid         = $mid;
        $this->secret      = $secret;
        $this->environment = $environment;

        $this->client = new \GuzzleHttp\Client(array_merge($clientOptions, [
            'base_uri' => $this->getBaseUrl(),
            'auth'     => [$this->mid, $this->secret]
        ]));
    }

    /**
     * Get the base URL for the environment
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        switch ($this->environment) {
            case self::ENVIRONMENT_LIVE_NA:
                return 'https://api-na.klarna.com/';
                break;
            case self::ENVIRONMENT_LIVE_EU:
                return 'https://api.klarna.com/';
                break;
            case self::ENVIRONMENT_PLAYGROUND_NA:
                return 'https://api-na.playground.klarna.com/';
            case self::ENVIRONMENT_PLAYGROUND_EU:
                return 'https://api.playground.klarna.com/';
            default:
                throw new InvalidEnvironmentException(sprintf('Invalid environment type "%s".', $this->environment));
        }
    }
}
