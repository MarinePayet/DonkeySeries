<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    
    #[Route('/category/{categoryName}', name: 'category_show')]
    public function show(CategoryRepository $categoryRepository, string $categoryName, ProgramRepository $programRepository): Response
    {   

        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if(!$category){
            return $this->redirectToRoute('app_error_404');
        }

        $categoryId = $category->getId();

        $programs = $programRepository->findBy(
            ['category' => $categoryId],
            ['id' => 'DESC'],
            3,
        );

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }

}
