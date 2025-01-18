<?php

namespace App\Models;

use App\Databases\MongoDB;

abstract class MongoAbstractModel
{
    protected $db;
    protected $collection;

    protected $collectionName;

    public function __construct()
    {
        $this->db = MongoDB::getInstance()->getDatabase();
        $this->collection = $this->db->selectCollection($this->collectionName);
    }
    abstract protected function createEntity(array $data);

    public function findAll(): array
    {
        $results = $this->collection->find()->toArray();

        $entities = [];
        foreach ($results as $result) {
            $entities[] = $this->createEntity($result);
        }

        return $entities;
    }


    public function delete($id)
    {
        return $this->collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
    }
}
