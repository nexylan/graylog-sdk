<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\Graylog\Api;

use Nexy\Graylog\Api\Search\Absolute;
use Nexy\Graylog\Api\Search\Keyword;
use Nexy\Graylog\Api\Search\Relative;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Search extends AbstractApi
{
    /**
     * @return Absolute
     */
    public function absolute()
    {
        return new Absolute($this->graylog);
    }

    /**
     * @return Keyword
     */
    public function keyword()
    {
        return new Keyword($this->graylog);
    }

    /**
     * @return Relative
     */
    public function relative()
    {
        return new Relative($this->graylog);
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiBasePath()
    {
        return '/search';
    }
}
