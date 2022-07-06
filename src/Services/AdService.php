<?php

namespace App\Services;

use App\Entity\Ad;
use App\Models\AdItemListResponse;
use App\Models\AdModel;
use App\Repository\AdRepository;

class AdService
{
    private $adRepository;

    public function __construct(AdRepository $adRepository)
    {
        $this->adRepository = $adRepository;
    }

    public function getAllAd(): array
    {
        $ads = $this->adRepository->getAdsOrderByDate();
        return array_map(fn(Ad $ad) => new AdModel($ad->getId(), $ad->getTitle(), $ad->getDescription(), $ad->getDatePost(), $ad->getAuthor()), $ads);
    }

    public function getAdById($id): AdModel
    {
        $ad = $this->adRepository->findOneBy(['id' => $id]);
        if($ad === null)
        {
            return new AdModel(-1, "NULL", "NULL", -1, -1, false);
        }
        return new AdModel($ad->getId(), $ad->getTitle(), $ad->getDescription(), $ad->getDatePost(), $ad->getAuthor());
    }
}