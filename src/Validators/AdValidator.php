<?php

namespace App\Validators;

use App\Entity\Ad;

class AdValidator
{
    /**
     * @var Ad
     */
    private $object;
    /**
     * @var string
     */
    private $msg;

    public function __construct(Ad $ad)
    {
        $this->object = $ad;
        $this->msg = 'Good';
    }

    public function isValid(): bool
    {
        if($this->object->getTitle() === null or strlen($this->object->getTitle()) < 1 or strlen($this->object->getTitle()) > 255)
        {
            $this->msg = "Error Title | [title is null or title < 1 or title > 255]";
            return false;
        }
        elseif($this->object->getAuthor() === null or $this->object->getAuthor() < 1)
        {
            $this->msg = "Error Author | [author is null or author < 1]";
            return false;
        }
        elseif($this->object->getDescription() === null or strlen($this->object->getDescription()) < 1)
        {
            $this->msg = "Error Description | [Description is null or description < 1] | ";
            return false;
        }
        else
        {
            return true;
        }
    }

    public function message(): string
    {
        return $this->msg;
    }

}