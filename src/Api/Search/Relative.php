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
     * @param string      $query
     * @param int         $range
     * @param int|null    $limit
     * @param int|null    $offset
     * @param string|null $filter
     * @param array|null  $fields
     * @param string|null $sort
     * @param bool|null   $decorate
     *
     * @return array
     */
    public function fetch(string $query, int $range, int $limit = null, int $offset = null, string $filter = null, array $fields = null, string $sort = null, bool $decorate = null): array
    {
        $parameters = [
            'query' => $query,
            'range' => $range,
        ];

        if (null !== $limit) {
            $parameters['limit'] = $limit;
        }
        if (null !== $offset) {
            $parameters['offset'] = $offset;
        }
        if (null !== $filter) {
            $parameters['filter'] = $filter;
        }
        if (null !== $fields) {
            $parameters['fields'] = implode(',', $fields);
        }
        if (null !== $sort) {
            $parameters['sort'] = $sort;
        }
        if (null !== $decorate) {
            $parameters['decorate'] = $decorate;
        }

        return $this->get('/', $parameters);
    }

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
