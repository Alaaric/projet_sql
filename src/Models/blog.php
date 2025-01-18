<?php

namespace App\Models;

use App\Entities\Article;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class Blog extends MongoAbstractModel
{
    protected $collectionName = 'articles';

    protected function createEntity(array $data): Article
    {
        return new Article(
            (string)$data['_id'],
            $data['titre'],
            $data['contenu'],
            $data['auteur'],
            $data['date_creation']->toDateTime(),
            $data['tags']->getArrayCopy()
        );
    }

    protected function extractData($entity): array
    {
        return [
            'titre' => $entity->getTitre(),
            'contenu' => $entity->getContenu(),
            'auteur' => $entity->getAuteur(),
            'date_creation' => new UTCDateTime($entity->getDateCreation()->getTimestamp() * 1000),
            'tags' => $entity->getTags(),
        ];
    }

    public function findFiltered(array $filters): array
    {
        $query = [];

        if (!empty($filters['tags'])) {
            $query['tags'] = ['$in' => $filters['tags']];
        }

        if (!empty($filters['auteur'])) {
            $query['auteur'] = $filters['auteur'];
        }

        $results = $this->collection->find($query)->toArray();

        $articles = [];
        foreach ($results as $result) {
            $articles[] = $this->createEntity((array)$result);
        }

        return $articles;
    }

    public function getUniqueTags(): array
    {
        return $this->collection->distinct('tags');
    }

    public function getUniqueAuteurs(): array
    {
        return $this->collection->distinct('auteur');
    }

    public function findById(string $id): ?Article
    {
        $result = $this->collection->findOne(['_id' => new ObjectId($id)]);

        if ($result) {
            return $this->createEntity((array)$result);
        }

        return null;
    }

    public function insert(Article $article): void
    {
        $this->collection->insertOne($this->extractData($article));
    }

    public function update(string $id, Article $article): void
    {
        $this->collection->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => $this->extractData($article)]
        );
    }
}