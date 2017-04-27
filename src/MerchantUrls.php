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

/**
 * Class MerchantUrls
 *
 * @package KlarnaCore
 */
class MerchantUrls extends ModelAbstract
{
    protected $baseUri;

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = \GuzzleHttp\Psr7\uri_for($value);
    }

    /**
     * @param string $name
     *
     * @return MerchantUrls|null|\Psr\Http\Message\UriInterface
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->buildUri($this->data[$name]);
        }

        return null;
    }

    /**
     * @param string $baseUri
     *
     * @return MerchantUrls
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = \GuzzleHttp\Psr7\uri_for($baseUri);

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $urls = [];
        foreach (array_keys($this->data) as $type) {
            $urls[$type] = (string)$this->$type;
        }

        return $urls;
    }

    /**
     * @param string $uri
     *
     * @return \Psr\Http\Message\UriInterface|static
     */
    protected function buildUri($uri)
    {
        // for BC we accept null which would otherwise fail in uri_for
        $uri = \GuzzleHttp\Psr7\uri_for($uri === null ? '' : $uri);

        if ($this->getBaseUri()) {
            $uri = \GuzzleHttp\Psr7\Uri::resolve(\GuzzleHttp\Psr7\uri_for($this->getBaseUri()), $uri);
        }

        return $uri->getScheme() === '' && $uri->getHost() !== '' ? $uri->withScheme('http') : $uri;
    }
}
