<?php

declare(strict_types=1);

namespace Nexy\Graylog\Exception;

use Psr\Http\Message\ResponseInterface;

final class HttpClientException extends GraylogSDKException
{
    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        parent::__construct($response->getReasonPhrase(), $response->getStatusCode());
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }


}
