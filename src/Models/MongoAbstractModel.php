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
        try {
            $results = $this->collection->find()->toArray();

            $entities = [];
            foreach ($results as $result) {
                $entities[] = $this->createEntity($result);
            }

            return $entities;
        } catch (\Exception $e) {
            throw new \Exception('Une erreur est survenue lors de la récupération des enregistrements.', 500, $e);
        }
    }


    public function delete($id)
    {
        try {
            return $this->collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        } catch (\Exception $e) {
            throw new \Exception('Une erreur est survenue lors de la suppression de l\'enregistrement.', 500, $e);
        }
    }
}
