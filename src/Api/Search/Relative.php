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
     * @param string      $field
     * @param string      $query
     * @param int         $range
     * @param int         $size
     * @param string|null $stackedFields
     * @param string|null $interval
     * @param string|null $filter
     * @param string|null $order
     *
     * @return array
     */
    public function termsHistogram(string $field, string $query, int $range, int $size, string $stackedFields = null, string $interval = null, string $filter = null, string $order = null)
    {
        $parameters = [
            'field' => $field,
            'query' => $query,
            'range' => $range,
            'size' => $size
        ];

        if (null !== $stackedFields) {
            $parameters['stacked_fields'] = $stackedFields;
        }
        if (null !== $interval) {
            $parameters['interval'] = $interval;
        }
        if (null !== $filter) {
            $parameters['filter'] = $filter;
        }
        if (null !== $order) {
            $parameters['order'] = $order;
        }

        return $this->get('/terms-histogram', $parameters);
    }

    /**
     * @param string      $query
     * @param string      $field
     * @param string      $interval
     * @param int         $range
     * @param string|null $filter
     * @param bool        $cardinality
     *
     * @return array
     */
    public function fieldHistogram(string $query, string $field, string $interval, int $range, string $filter = null, bool $cardinality = false)
    {
        $parameters = [
            'query' => $query,
            'field' => $field,
            'interval' => $interval,
            'range' => $range,
            'cardinality' => $cardinality ? 'true' : 'false',
        ];

        if (null !== $filter) {
            $parameters['filter'] = $filter;
        }

        return $this->get('/fieldhistogram', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiBasePath()
    {
        return '/search/universal/relative';
    }
}
