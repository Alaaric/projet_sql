<?php

namespace App\Models;

use App\Entities\Article;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use App\Exceptions\ArticleModelException;
use Exception;

class ArticleModel extends MongoAbstractModel
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
        try {
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
        } catch (Exception $e) {
            throw new ArticleModelException('Une erreur est survenue lors de la récupération des articles filtrés.', 500, $e);
        }
    }

    public function getUniqueTags(): array
    {
        try {
            return $this->collection->distinct('tags');
        } catch (Exception $e) {
            throw new ArticleModelException('Une erreur est survenue lors de la récupération des tags uniques.', 500, $e);
        }
        
    }

    public function getUniqueAuteurs(): array
    {
        try {
            return $this->collection->distinct('auteur');
        } catch (Exception $e) {
            throw new ArticleModelException('Une erreur est survenue lors de la récupération des auteurs uniques.', 500, $e);
        }
    }

    public function findById(string $id): ?Article
    {
        try {
            $result = $this->collection->findOne(['_id' => new ObjectId($id)]);

            if ($result) {
                return $this->createEntity((array)$result);
            }

            return null;
        } catch (Exception $e) {
            throw new ArticleModelException('Une erreur est survenue lors de la récupération de l\'article par ID.', 500, $e);
        }
    }

    public function insert(Article $article): void
    {
        try {
            $this->collection->insertOne($this->extractData($article));
        } catch (Exception $e) {
            throw new ArticleModelException('Une erreur est survenue lors de l\'insertion de l\'article.', 500, $e);
        }
    }

    public function update(string $id, Article $article): void
    {
        try {
            $data = $this->extractData($article);
            unset($data['date_creation']);

            $this->collection->updateOne(
                ['_id' => new ObjectId($id)],
                ['$set' => $data]
            );
        } catch (Exception $e) {
            throw new ArticleModelException('Une erreur est survenue lors de la mise à jour de l\'article.', 500, $e);
        }
    }
}