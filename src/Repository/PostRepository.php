<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Iterator\Iterator;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class PostRepository extends DocumentRepository
{
    /**
     * @param string|null $query
     * @return array
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function findByQuery(?string $query): array
    {
        $qb = $this->createQueryBuilder();
        if ($query) {
            $qb = $qb->field('title')->equals(new \MongoDB\BSON\Regex($query));
        }

        /** @var Iterator $result */
        $result = $qb->getQuery()->execute();

        return $result->toArray();
    }
}
