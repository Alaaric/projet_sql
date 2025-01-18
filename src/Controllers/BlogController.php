<?php

namespace App\Controllers;

use App\Models\Blog;
use App\Entities\Article;

class BlogController extends AbstractController
{
    protected Blog $model;

    public function __construct()
    {
        $this->model = new Blog();
    }

    public function index()
    {
        $filters = [
            'tags' => $_GET['tags'] ?? null,
            'auteur' => $_GET['auteur'] ?? null,
        ];

        $articles = $this->model->findFiltered($filters);
        $tags = $this->model->getUniqueTags();
        $auteurs = $this->model->getUniqueAuteurs();
        $this->render('blog', ['articles' => $articles, 'filters' => $filters, 'tags' => $tags, 'auteurs' => $auteurs]);
    }

    public function create()
    {
        if ($this->isRequestMethod('POST')) {
            $data = $this->getInput();
            $tags = isset($data['tags']) ? $data['tags'] : [];
            $article = new Article(
                '',
                $data['titre'],
                $data['contenu'],
                $data['auteur'],
                new \DateTime(),
                $tags
            );
            $this->model->insert($article);
            $this->redirect('/blog');
        } else {
            $this->render('create_article');
        }
    }

    public function edit($id)
    {
        if ($this->isRequestMethod('POST')) {
            $data = $this->getInput();
            $tags = isset($data['tags']) ? $data['tags'] : [];
            $article = new Article(
                $id,
                $data['titre'],
                $data['contenu'],
                $data['auteur'],
                $data['date_creation'],
                $tags
            );
            $this->model->update($id, $article);
            $this->redirect('/blog');
        } else {
            $article = $this->model->findById($id);
            $tags = $this->model->getUniqueTags();
            $this->render('blog', ['article' => $article, 'allTags' => $tags]);
        }
    }

    public function delete($id)
    {
        $this->model->delete($id);
        $this->redirect('/blog');
    }
}