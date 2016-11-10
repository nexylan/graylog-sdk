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

use Nexy\Graylog\Api\User\Token;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class User extends AbstractApi
{
    public function all()
    {
        return $this->get('/');
    }

    public function tokens($username)
    {
        $token = new Token($this->graylog);
        $token->setUsername($username);

        return $token;
    }

    protected function getApiBasePath()
    {
        return '/users';
    }
}
