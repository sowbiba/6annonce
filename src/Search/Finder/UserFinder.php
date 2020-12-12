<?php

namespace App\Search\Finder;

use App\Search\Connector\ConnectorInterface;

class UserFinder
{
    /**
     * @var ConnectorInterface
     */
    private $connector;

    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * {@inheritdoc}
     */
    public function find($query, int $limit = null, array $options = []): array
    {
        return $this->connector->find($query, $limit, $options);
    }
}
