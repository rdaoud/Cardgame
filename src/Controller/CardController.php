<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    private $cardRepository;
    public function __construct(CardRepository $cardRepository){
        $this->cardRepository = $cardRepository;
    }
    /**
     * @Route("/card", name="card")
     */
    public function index(){
        $cardList = $this->cardRepository->findAll();   
        return $this->render('card/index.html.twig', [
            'cardList' => $cardList,
            ]);
    }
    /**
     * @Route("/user", name="user")
     */
    public function user(){
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/create-card", name="create-card")
     */
    public function createCard(Request $request): Response{
        $card = new Card();
        $form = $this->createForm( CardType::class, $card);
        $form->handleRequest($request);   
        if ($form->isSubmitted() && $form->isValid()) {
            $card->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $image = $form->get('image')->getData();
            $imageName = 'card-'.uniqid().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('cards_folder'),
                $imageName
            );
            $card->setImage($imageName);
            $entityManager->persist($card);
            $entityManager->flush();       
            return $this->redirectToRoute('user');
        }
        return $this->render('card/form.html.twig', ['form' => $form->createView(),]);
    }
    
}
