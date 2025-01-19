<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Entities\Article;
use Exception;
use App\Exceptions\ArticleModelException;

class ArticleController extends AbstractController
{
    protected ArticleModel $model;

    public function __construct()
    {
        $this->model = new ArticleModel();
    }

    public function index()
    {
        try {
            $filters = [
                'tags' => $_GET['tags'] ?? null,
                'auteur' => $_GET['auteur'] ?? null,
            ];

            $articles = $this->model->findFiltered($filters);
            $tags = $this->model->getUniqueTags();
            $auteurs = $this->model->getUniqueAuteurs();
            $this->render('article', ['articles' => $articles, 'filters' => $filters, 'tags' => $tags, 'auteurs' => $auteurs]);
        } catch (ArticleModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la récupération des articles. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors du chargement des articles.']);
        }
    }

    public function create()
    {
        try {
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
                $this->redirect('/article');
            } else {
                $tags = $this->model->getUniqueTags();
                $this->render('create_article', ['tags' => $tags]);
            }
        } catch (ArticleModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la création de l\'article. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la création de l\'article.']);
        }
    }

    public function edit($id)
    {
        try {
            if ($this->isRequestMethod('POST')) {
                $data = $this->getInput();
                $tags = isset($data['tags']) ? $data['tags'] : [];
                $article = new Article(
                    $id,
                    $data['titre'],
                    $data['contenu'],
                    $data['auteur'],
                    new \DateTime(),
                    $tags
                );
                $this->model->update($id, $article);
                $this->redirect('/article');
            } else {
                $article = $this->model->findById($id);
                $tags = $this->model->getUniqueTags();
                $this->render('article', ['article' => $article, 'tags' => $tags]);
            }
        } catch (ArticleModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la modification de l\'article. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la modification de l\'article.']);
        }
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
            $this->redirect('/article');
        } catch (ArticleModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la suppression de l\'article. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la suppression de l\'article.']);
        }
    }
}