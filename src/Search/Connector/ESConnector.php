<?php

namespace App\Search\Connector;

use FOS\ElasticaBundle\Finder\FinderInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;

class ESConnector implements ConnectorInterface
{
    /**
     * @var FinderInterface
     */
    private $finder;

    public function __construct(PaginatedFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    /**
     * {@inheritdoc}
     */
    public function find($query, int $limit = null, array $options = []): array
    {
        $query = new \Elastica\Query();
        foreach ($query as $field => $value) {
            $query->setParam($field, $value);
        }
//        $agg = new \Elastica\Aggregation\Terms('tags');
//        $agg->setField('companyGroup');
//        $query->addAggregation($agg);

//        $companies = $this->finder->findPaginated($query);
//        $companies->setMaxPerPage($params['limit']);
//        $companies->setCurrentPage($params['page']);

        $aggs = $companies->getAdapter()->getAggregations();


        return $this->finder->find($query, $limit, $options);
    }
}
