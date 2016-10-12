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
final class Keyword extends AbstractApi
{
    /**
     * @param string      $query
     * @param string      $rangeKeyword
     * @param array|null  $fields
     * @param int|null    $limit
     * @param int|null    $offset
     * @param string      $filter
     * @param string|null $sort
     *
     * @return array
     */
    public function fetch(string $query, string $rangeKeyword, array $fields = null, int $limit = null, int $offset = null, string $filter = null, string $sort = null)
    {
        $parameters = [
            'query' => $query,
            'keyword' => $rangeKeyword,
        ];

        if (null !== $fields) {
            $parameters['fields'] = implode(',', $fields);
        }
        if (null !== $limit) {
            $parameters['limit'] = $limit;
        }
        if (null !== $offset) {
            $parameters['offset'] = $offset;
        }
        if (null !== $filter) {
            $parameters['filter'] = $filter;
        }
        if (null !== $sort) {
            $parameters['sort'] = $sort;
        }

        return $this->get('/', $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiBasePath()
    {
        return '/search/universal/keyword';
    }
}
