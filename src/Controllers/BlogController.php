<?php

namespace App\Controllers;

use App\Models\Blog;

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
            'tag' => $_GET['tag'] ?? null,
            'auteur' => $_GET['auteur'] ?? null,
        ];

        $articles = $this->model->findFiltered($filters);
        $tags = $this->model->getUniqueTags();
        $auteurs = $this->model->getUniqueAuteurs();
        $this->render('blog', ['articles' => $articles, 'filters' => $filters, 'tags' => $tags, 'auteurs' => $auteurs]);
    }

    public function show($id)
    {
        $article = $this->model->findById($id);
        $this->render('article', ['article' => $article]);
    }

    public function create()
    {
        if ($this->isRequestMethod('POST')) {
            $data = $this->getInput();
            $data['date_creation'] = new \MongoDB\BSON\UTCDateTime();
            $this->model->insert($data);
            $this->redirect('/blog');
        } else {
            $this->render('create_article');
        }
    }

    public function edit($id)
    {
        if ($this->isRequestMethod('POST')) {
            $data = $this->getInput();
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
            $this->model->update($id, $data);
            $this->redirect('/blog');
        } else {
            $article = $this->model->findById($id);
            $this->render('blog', ['article' => $article]);
        }
    }

    public function delete($id)
    {
        $this->model->delete($id);
        $this->redirect('/blog');
    }
}