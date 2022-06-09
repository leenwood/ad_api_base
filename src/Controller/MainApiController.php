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


        $ad->addNewAd($JsonInput);
        $ad->setDatePost(time());
        $adValidator = new AdValidator($ad);
        if($adValidator->isValid())
        {
            $this->getDoctrine()->getManager()->persist($ad);
            $this->getDoctrine()->getManager()->flush($ad);
            return $this->json([
                'result' => 'success',
                'message' => '',
                'date' => date('d-m-Y')
            ]);
        }
        else
        {
            return $this->json([
                'result' => 'error',
                'message' => $adValidator->message(),
                'date' => date('d-m-Y')
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
                'date' => date('d-m-Y')
            ]);
        }
        $JsonInput = json_decode($request->getContent(), true);

        $ad->addNewAd($JsonInput);
        $this->getDoctrine()->getManager()->persist($ad);
        $this->getDoctrine()->getManager()->flush($ad);
        return $this->json([
            'result' => 'success',
            'message' => '',
            'date' => date('d-m-Y')
        ]);
    }
}
