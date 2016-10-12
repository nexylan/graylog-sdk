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

namespace Nexy\Graylog\Api\User;

use Nexy\Graylog\Api\AbstractApi;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Token extends AbstractApi
{
    /**
     * @var string
     */
    private $username;

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function all()
    {
        return $this->get('/');
    }

    public function create(string $name)
    {
        return $this->post('/'.rawurldecode($name));
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiBasePath()
    {
        return '/users/'.rawurlencode($this->username).'/tokens';
    }
}
