<?php

namespace App\Entities;

class Article
{
    private string $id;
    private string $titre;
    private string $contenu;
    private string $auteur;
    private \DateTime $dateCreation;
    private array $tags;

    public function __construct(string $id, string $titre, string $contenu, string $auteur, \DateTime $dateCreation, array $tags)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->dateCreation = $dateCreation;
        $this->tags = $tags;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }

    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}