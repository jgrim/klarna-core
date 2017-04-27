<?php namespace KlarnaCore;

/**
 * Copyright 2017 Jason Grim
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    KlarnaCore
 * @author     Jason Grim <me@jasongrim.com>
 */

use KlarnaCore\Exception\InvalidEnvironmentException;

/**
 * Class Resource
 *
 * @package KlarnaCore
 */
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
