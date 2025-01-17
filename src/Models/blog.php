<?php

namespace App\Models;

class Blog extends MongoModel
{
    protected $collectionName = 'articles';

    public function findFiltered(array $filters)
    {
        $query = [];

        if (!empty($filters['tag'])) {
            $query['tags'] = $filters['tag'];
        }

        if (!empty($filters['auteur'])) {
            $query['auteur'] = $filters['auteur'];
        }

        return $this->collection->find($query)->toArray();
    }

    public function getUniqueTags()
    {
        return $this->collection->distinct('tags');
    }

    public function getUniqueAuteurs()
    {
        return $this->collection->distinct('auteur');
    }
}
