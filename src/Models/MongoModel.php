<?php

namespace App\Models;

use App\Databases\MongoDB;

abstract class MongoModel
{
    protected $db;
    protected $collection;

    protected $collectionName;

    public function __construct()
    {
        $this->db = MongoDB::getInstance()->getDatabase();
        $this->collection = $this->db->selectCollection($this->collectionName);
    }

    public function findAll()
    {
        return $this->collection->find()->toArray();
    }

    public function findById($id)
    {
        return $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
    }

    public function insert($document)
    {
        return $this->collection->insertOne($document);
    }

    public function update($id, $document)
    {
        return $this->collection->updateOne(['_id' => new \MongoDB\BSON\ObjectId($id)], ['$set' => $document]);
    }

    public function delete($id)
    {
        return $this->collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
    }
}
