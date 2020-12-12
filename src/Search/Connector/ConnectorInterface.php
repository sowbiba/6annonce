<?php

namespace App\Search\Connector;

interface ConnectorInterface
{
    /**
     * Searches for query results within a given limit.
     *
     * @param mixed $query Can be a string, an array or an \Elastica\Query object
     * @param int|null $limit How many results to get
     * @param array $options
     *
     * @return array results
     */
    public function find($query, int $limit = null, array $options = []): array;
}
