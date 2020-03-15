<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    /**
     * @Route("/deck", name="deck")
     */
    public function index()
    {
        return $this->render('deck/index.html.twig', [
            'controller_name' => 'DeckController',
        ]);
    }

    public function createDeck(){

        $idUser = $request->get('id');
        $idCard = $request->get('id');

        $deckCard = new Deck();
        $deck = $this->UserRepository->findOneBy(['id' => $idUser]);
        $deck = $this->CardRepository->findOneBy(['id' => $idCard]);

        $deckCard->setCards($card);
        $deckCard->setUser($user);

        $this->manager->persist($card);
        $this->manager->flush();

    }
}
