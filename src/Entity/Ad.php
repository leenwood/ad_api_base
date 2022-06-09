<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\AdRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdRepository::class)
 */
class Ad
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=255)
     * @var string
    */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $datePost;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $author;

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
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getDatePost(): int
    {
        return $this->datePost;
    }

    /**
     * @param int $datePost
     */
    public function setDatePost(int $datePost): void
    {
        $this->datePost = $datePost;
    }

    /**
     * @return int
     */
    public function getAuthor(): int
    {
        return $this->author;
    }

    /**
     * @param int $author
     */
    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    public function addNewAd(array $input): void
    {
        foreach ($input as $key => $value)
        {
            if($key === 'title')
                $this->setTitle($value);
            if($key === 'description')
                $this->setDescription($value);
            if($key === 'author')
                $this->setAuthor($value);
        }
    }
}