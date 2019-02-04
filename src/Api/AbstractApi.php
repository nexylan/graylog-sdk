<?php

declare(strict_types=1);

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\Graylog\Api;

use Nexy\Graylog\Exception\HttpClientException;
use Nexy\Graylog\Graylog;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractApi
{
    /**
     * @var Graylog
     */
    protected $graylog;

    /**
     * @param Graylog $graylog
     */
    public function __construct(Graylog $graylog)
    {
        $this->graylog = $graylog;
    }

    /**
     * Call GET http client request.
     *
     * @param string $path       Request path
     * @param array  $parameters GET Parameters
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return array
     */
    final protected function get($path, array $parameters = [], array $headers = [])
    {
        $uri = $this->getApiBasePath().$path;
        if (count($parameters)) {
            $uri .= '?'.http_build_query($parameters);
        }

        return $this->parseResponseContent($this->graylog->getHttpClient()->get($uri, $headers));
    }

    /**
     * Call POST http client request.
     *
     * @param string $path    Request path
     * @param array  $body    Request body
     * @param array  $headers Reconfigure the request headers for this call only
     *
     * @return array
     */
    final protected function post($path, array $body = null, array $headers = [])
    {
        return $this->parseResponseContent(
            $this->graylog->getHttpClient()->post($path, $headers, $body ? json_encode($body) : null)
        );
    }

    abstract protected function getApiBasePath();

    private function parseResponseContent(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 400 || $statusCode < 200) {
            throw new HttpClientException($response);
        }
        return json_decode($response->getBody()->getContents(), true);
    }
}
