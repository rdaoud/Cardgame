<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/category", name="category")
     */
    public function index(){
        $categoryList = $this->categoryRepository->findAll();   
        return $this->render('category/index.html.twig', [
            'categoryList' => $categoryList,
            ]);
    }
    /**
     * @Route("/user", name="user")
     */
    public function user(){
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/create-category", name="create-category")
     */
    public function createCategory(Request $request): Response{
        $category = new Category();
        $form = $this->createForm( CategoryType::class, $category);
        $form->handleRequest($request);   
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();       
            return $this->redirectToRoute('user');
        }
        return $this->render('category/form.html.twig', ['form' => $form->createView(),]);
    }
}
