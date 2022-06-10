<?php

namespace App\Controller;

use App\Entity\Ad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Validators\AdValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class MainApiController extends AbstractController
{
    /**
     * @Route("/api", name="app_main_api", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json([
            'title' =>  "Test Title",
            'body' => "test body"]);
    }

    /**
     * @Route("/api/create_ad", name="create_ad", methods={"POST"})
     */
    public function createAd(Request $request): Response
    {
        $ad = new Ad();
        $JsonInput = json_decode($request->getContent(), true);


        $ad->addNewValue($JsonInput);
        $ad->setDatePost(time());
        $adValidator = new AdValidator($ad);
        if($adValidator->isValid())
        {
            $this->getDoctrine()->getManager()->persist($ad);
            $this->getDoctrine()->getManager()->flush($ad);
            return $this->json([
                'result' => 'success',
                'message' => '',
                'date' => date('d-m-Y'),
                'inputValue' => $JsonInput
            ]);
        }
        else
        {
            return $this->json([
                'result' => 'error',
                'message' => $adValidator->message(),
                'date' => date('d-m-Y'),
                'inputValue' => $JsonInput
            ]);
        }
    }

    /**
     * @Route("/api/edit_ad/{id}", name="edit_ad", methods={"POST"})
     */
    public function editAd(Request $request, $id): Response
    {
        $ad = $this->getDoctrine()
            ->getManager()
            ->getRepository(Ad::class)
            ->findOneBy(['id' => $id]);
        if ($ad === null)
        {
            return $this->json([
                'result' => 'error',
                'message' => sprintf("Not found ad with id: %s", $id),
                'date' => date('d-m-Y'),
                'inputValue' => ['id' => $id]
            ]);
        }
        $oldVersion = $ad;
        $JsonInput = json_decode($request->getContent(), true);
        $ad->addNewValue($JsonInput);

        $adValidator = new AdValidator($ad);
        if($adValidator->isValid())
        {
            $this->getDoctrine()->getManager()->persist($ad);
            $this->getDoctrine()->getManager()->flush($ad);
            return $this->json([
                'result' => 'success',
                'message' => '',
                'date' => date('d-m-Y'),
                'inputValue' => $JsonInput,
                'oldVersion' => $oldVersion
            ]);
        }
        else
        {
            $ad->addNewAd($JsonInput);
            $this->getDoctrine()->getManager()->persist($ad);
            $this->getDoctrine()->getManager()->flush($ad);
            return $this->json([
                'result' => 'error',
                'message' => $adValidator->message(),
                'date' => date('d-m-Y'),
                'inputValue' => $JsonInput,
                'oldVersion' => $oldVersion
            ]);
        }
    }

    /**
     * @Route("/api/ads", name="ads_list", methods={"GET"})
     */
    public function showAllAd(): Response
    {
        $ads = $this->getDoctrine()
            ->getManager()
            ->getRepository(Ad::class)
            ->findAll();

        return $this->json($ads);
    }

    /**
     * @Route("/api/ad/{id}", name="ad_byId", methods={"GET"})
     */
    public function showAd(Request $request, $id): Response
    {
        $ad = $this->getDoctrine()
            ->getManager()
            ->getRepository(Ad::class)
            ->findOneBy(['id' => $id]);
        if ($ad === null)
        {
            return $this->json([
                'result' => 'error',
                'message' => sprintf("Not found ad with id: %s", $id),
                'date' => date('d-m-Y'),
                'inputValue' => ['id' => $id]
            ]);
        }

        return $this->json($ad);
    }

    /**
     * @Route("/api/delete_ad/{id}", name="ad_delete", methods={"POST"})
     */
    public function deleteAd(Request $request, $id): Response
    {
        $ad = $this->getDoctrine()
            ->getManager()
            ->getRepository(Ad::class)
            ->findOneBy(['id' => $id]);
        $JsonInput = json_decode($request->getContent(), true);
        if ($ad === null or $ad->getAuthor() !== (int)$JsonInput['author'])
        {
            return $this->json([
                'result' => 'error',
                'message' => sprintf("Not found ad with id: %s", $id),
                'date' => date('d-m-Y'),
                'inputValue' => ['id' => $id]
            ]);
        }

        $this->getDoctrine()->getManager()->remove($ad);
        $this->getDoctrine()->getManager()->flush();

        return $this->json([
            'result' => 'success',
            'message' => "",
            'date' => date('d-m-Y'),
            'inputValue' => $JsonInput
        ]);
    }
}
