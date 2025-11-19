<?php
namespace App\Model;

class Movie
{
    private ?int $id = null;
    private string $title = '';
    private string $description = '';
    private \DateTime $publishAt;
    private int $duration = 0;
    private string $cover = '';
    private array $categories = [];

    public function __construct() {
        $this->publishAt = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): void { $this->title = $title; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getPublishAt(): \DateTime { return $this->publishAt; }
    public function setPublishAt(\DateTime $publishAt): void { $this->publishAt = $publishAt; }

    public function getDuration(): int { return $this->duration; }
    public function setDuration(int $duration): void { $this->duration = $duration; }

    public function getCover(): string { return $this->cover; }
    public function setCover(string $cover): void { $this->cover = $cover; }

    public function getCategories(): array { return $this->categories; }
    public function addCategory($category): void { $this->categories[] = $category; }
}
