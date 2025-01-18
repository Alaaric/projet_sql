<?php

namespace App\Entities;

class Order
{
    private string $id;
    private string $userId;
    private \DateTime $dateOrder;
    private string $status;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getDateOrder(): \DateTime
    {
        return $this->dateOrder;
    }

    public function setDateOrder(\DateTime $dateOrder): void
    {
        $this->dateOrder = $dateOrder;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}