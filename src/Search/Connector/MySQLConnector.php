<?php

namespace App\Search\Connector;

use Doctrine\ORM\EntityRepository;

class MySQLConnector implements ConnectorInterface
{
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function find($query, int $limit = null, array $options = []): array
    {
        return $this->entityRepository->findBy($query, null, $limit);
    }
}
