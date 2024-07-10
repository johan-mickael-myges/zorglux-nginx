<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Repository\GalleryRepository;
use App\Service\Blog\BlogRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gallery', name: 'gallery_')]
class GalleryController extends AbstractController
{
    #[Route(
        '',
        name: 'index',
        methods: ['GET']
    )]
    public function index(BlogRepositoryService $blogRepositoryService, GalleryRepository $galleryRepository): Response
    {
        $blog = $blogRepositoryService->getPublicBlog([
            'limit' => 6,
        ]);
        $images = $galleryRepository::all();
        return $this->render('@gallery/index.html.twig', [
            'blogs' => $blog,
            'galleries' => $images,
        ]);
    }
}
