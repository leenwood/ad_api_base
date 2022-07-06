<?php

namespace App\Models;

class AdModel
{

    private int $id;
    private string $title;
    private string $description;
    private int $datePost;
    private int $authorId;
    private bool $available;

    /**
     * @param int $id - ИД объявления
     * @param string $title - Заголовок объявления
     * @param string $description - Описание объявления
     * @param int $datePost - Дата публикации
     * @param int $authorId - Автор публикации
     */
    public function __construct(int $id, string $title, string $description, int $datePost, int $authorId, bool $available = true)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->datePost = $datePost;
        $this->authorId = $authorId;
        $this->available = $available;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getDatePost(): int
    {
        return $this->datePost;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->available;
    }
}