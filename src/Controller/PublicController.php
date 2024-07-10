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

#[Route('/', name: 'public_')]
class PublicController extends AbstractController
{
    #[Route(
        '',
        name: 'index',
        options: [
            'sitemap' => [
                'changefreq' => UrlConcrete::CHANGEFREQ_ALWAYS,
                'priority' => 1.0,
            ]
        ],
        methods: ['GET']
    )]
    public function index(BlogRepositoryService $blogRepositoryService, GalleryRepository $galleryRepository): Response
    {
        $blog = $blogRepositoryService->getPublicBlog([
            'limit' => 6,
        ]);
        $images = $galleryRepository::all([
            'limit' => 4,
        ]);
        return $this->render('public/index.html.twig', [
            'blogs' => $blog,
            'galleries' => $images,
        ]);
    }

    #[Route(
        'about',
        name: 'about',
        options: [
            'sitemap' => [
                'section' => 'public',
                'priority' => 0.8,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY,
            ]
        ],
        methods: ['GET']
    )]
    public function about(BlogRepositoryService $blogRepositoryService, GalleryRepository $galleryRepository): Response
    {
        $blogs = $blogRepositoryService->getPublicBlog([
            'limit' => 3,
        ]);

        $images = $galleryRepository::all([
            'limit' => 4,
        ]);

        return $this->render('static/about.html.twig', [
            'galleries' => $images,
            'blogs' => $blogs,
        ]);
    }

    #[Route(
        'social-share',
        name: 'social_share',
        options: [
            'sitemap' => [
                'section' => 'public',
                'priority' => 0.8,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY,
            ]
        ],
        methods: ['GET']
    )]
    public function socialShare(GalleryRepository $galleryRepository, BlogRepositoryService $blogRepositoryService): Response
    {
        $blogs = $blogRepositoryService->getPublicBlog([
            'limit' => 3,
        ]);

        $images = $galleryRepository::all([
            'limit' => 4,
        ]);
        return $this->render('static/social-share.html.twig', [
            'galleries' => $images,
            'blogs' => $blogs,
        ]);
    }

    #[Route(
        'contact',
        name: 'contact',
        options: [
            'sitemap' => [
                'section' => 'public',
                'priority' => 0.8,
                'changefreq' => UrlConcrete::CHANGEFREQ_WEEKLY,
            ]
        ],
        methods: ['GET']
    )]
    public function contact(GalleryRepository $galleryRepository, BlogRepositoryService $blogRepositoryService): Response
    {
        $blogs = $blogRepositoryService->getPublicBlog([
            'limit' => 3,
        ]);

        $images = $galleryRepository::all([
            'limit' => 4,
        ]);
        return $this->render('static/contact.html.twig', [
            'galleries' => $images,
            'blogs' => $blogs,
        ]);
    }
}
