<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\GalleryRepository;
use App\Service\Blog\BlogCreatorService;
use App\Service\Blog\BlogRepositoryService;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    #[Route(
        '/',
        name: 'index',
        options: [
            'sitemap' => [
                'section' => 'blog',
                'changefreq' => UrlConcrete::CHANGEFREQ_ALWAYS,
                'priority' => 0.9,
            ]
        ],
        methods: ['GET']
    )]
    #[IsGranted('list')]
    public function index(BlogRepositoryService $service, GalleryRepository $galleryRepository): Response
    {
        $images = $galleryRepository::all([
            'limit' => 4,
        ]);
        return $this->render('blog/index.html.twig', [
            'blogs' => $service->getPublicBlog(),
            'galleries' => $images,
        ]);
    }

    #[Route('/write', name: 'write', methods: ['GET', 'POST'])]
    #[IsGranted('write')]
    public function write(Request $request, BlogCreatorService $service): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->create($blog);

            return $this->redirectToRoute('blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/write.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'read', methods: ['GET'])]
    #[IsGranted('read', 'blog')]
    public function read(Blog $blog, BlogRepositoryService $blogRepositoryService): Response
    {
        $blogs = $blogRepositoryService->getPublicBlog([
            'limit' => 3,
            'exclude' => [$blog->getId()],
        ]);

        return $this->render('blog/read.html.twig', [
            'blog' => $blog,
            'blogs' => $blogs,
        ]);
    }
}
