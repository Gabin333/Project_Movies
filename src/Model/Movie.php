<?php
namespace App\Model;

use Mithridatem\Validation\Attributes\NotBlank;
use Mithridatem\Validation\Attributes\Length;
use Mithridatem\Validation\Attributes\Positive;
use Mithridatem\Validation\Validator;

class Movie
{
    private ?int $id = null;

    #[NotBlank]
    #[Length(2, 50)]
    private string $title = '';

    #[NotBlank]
    #[Length(5, 255)]
    private string $description = '';

    private \DateTime $publishAt;

    #[Positive]
    private int $duration = 90;

    private string $cover = '';
    private array $categories = [];

    public function __construct() {
        $this->publishAt = new \DateTime();
    }

    // Getters & setters
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
    public function addCategory(int $categoryId): void { $this->categories[] = $categoryId; }

    // Validation
    public function validate(): void
    {
        $validator = new Validator();
        $validator->validate($this);
    }
}
