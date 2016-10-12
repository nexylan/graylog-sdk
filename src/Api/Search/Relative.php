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

namespace Nexy\Graylog\Api\Search;

use Nexy\Graylog\Api\AbstractApi;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Relative extends AbstractApi
{
    /**
     * @param string      $field
     * @param string      $query
     * @param int         $range
     * @param int|null    $size
     * @param string|null $filter
     *
     * @return array
     */
    public function terms(string $field, string $query, int $range, int $size = null, string $filter = null)
    {
        $parameters = [
            'field' => $field,
            'query' => $query,
            'range' => $range,
        ];

        if (null !== $size) {
            $parameters['size'] = $size;
        }
        if (null !== $filter) {
            $parameters['filter'] = $filter;
        }

        return $this->get('/terms', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiBasePath()
    {
        return '/search/universal/relative';
    }
}
