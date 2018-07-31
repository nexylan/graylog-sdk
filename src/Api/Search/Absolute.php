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
 * @author Jérôme Pogeant <p-jerome@hotmail.fr>
 */
final class Absolute extends AbstractApi
{
    /**
     * @param string      $query
     * @param string      $from
     * @param string      $to
     * @param int|null    $limit
     * @param int|null    $offset
     * @param string|null $filter
     * @param array|null  $fields
     * @param string|null $sort
     * @param bool        $decorate
     *
     * @return array
     */
    public function fetch(string $query, string $from, string $to, int $limit = null, int $offset = null, string $filter = null, array $fields = null, string $sort = null, bool $decorate = true): array
    {
        $parameters = [
            'query' => $query,
            'from' => $from,
            'to' => $to,
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
        if (!$decorate) {
            $parameters['decorate'] = $decorate;
        }

        return $this->get('/', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiBasePath()
    {
        return '/search/universal/absolute';
    }
}
