<?php

namespace App\EventListener;

use App\Entity\Blog;
use App\Repository\GalleryRepository;
use App\Service\Blog\BlogRepositoryService;
use Presta\SitemapBundle\Sitemap\Url\GoogleImage;
use Presta\SitemapBundle\Sitemap\Url\GoogleImageUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\GoogleNewsUrlDecorator;
use Presta\SitemapBundle\Sitemap\Url\GoogleVideo;
use Presta\SitemapBundle\Sitemap\Url\GoogleVideoUrlDecorator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly BlogRepositoryService $blogRepositoryService,
        private readonly GalleryRepository $galleryRepository
    ) {}

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerBlogUrls($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerNewsUrls($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerGalleryUrls($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerVideoUrls($event->getUrlContainer(), $event->getUrlGenerator());
    }

    public function registerBlogUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        /**
         * @var Blog[] $posts posts
         */
        $posts = $this->blogRepositoryService->getPublicBlog();
        foreach ($posts as $post) {
            $blogUrl = new UrlConcrete(
                $router->generate(
                    'blog_read',
                    ['slug' => $post->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $post->getUpdatedAt(),
                UrlConcrete::CHANGEFREQ_WEEKLY,
                1.0
            );

            $imageUrl = new GoogleImageUrlDecorator($blogUrl);
            $imageUrl->addImage(new GoogleImage(
                $post->getThumbnail(),
                $post->getDescription(),
                'Paris, France',
                $post->getTitle(),
            ));
            $urls->addUrl($imageUrl, 'blog');
        }
    }

    public function registerNewsUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        /**
         * @var Blog[] $newsArticles
         */
        $newsArticles = $this->blogRepositoryService->getPublicBlog();
        foreach ($newsArticles as $article) {
            $newsUrl = new UrlConcrete(
                $router->generate(
                    'blog_read',
                    ['slug' => $article->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $article->getUpdatedAt(),
                UrlConcrete::CHANGEFREQ_HOURLY,
                1.0
            );

            $newsDecorator = new GoogleNewsUrlDecorator(
                $newsUrl,
                'Actualités sur Zorglux',
                'fr',
                $article->getCreatedAt(),
                $article->getTitle()
            );

            $newsDecorator->setKeywords($this->getNewsKeywords($article));

            $imageUrl = new GoogleImageUrlDecorator($newsDecorator);
            $imageUrl->addImage(new GoogleImage(
                $article->getThumbnail(),
                $article->getDescription(),
                'Paris, France',
                $article->getTitle(),
            ));
            $urls->addUrl($imageUrl, 'news');
        }
    }

    private function getNewsKeywords(Blog $article): array
    {
        $keywords = explode(' ', $article->getTitle());
        $keywords = array_filter($keywords, fn($keyword) => strlen($keyword) > 2);
        return array_values(array_merge($keywords, ['Zorglux', 'Actualités', 'Blog', 'Article', 'News', 'SEO', 'ESGI']));
    }

    public function registerGalleryUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $galleryImages = $this->galleryRepository::all();

        $galleryUrl = new UrlConcrete(
            $router->generate(
                'gallery_index',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            new \DateTime(),
            UrlConcrete::CHANGEFREQ_DAILY,
            1.0
        );

        $imageUrls = [];
        foreach ($galleryImages as $image) {
            $imageUrls[] = new GoogleImage(
                $router->generate(
                    'public_index',
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ) . 'images/gallery/' . $image['src'],
                $image['alt'],
                'Paris, France',
                $image['title']
            );
        }

        if ($imageUrls) {
            $imageUrlDecorator = new GoogleImageUrlDecorator($galleryUrl);
            foreach ($imageUrls as $imageUrl) {
                $imageUrlDecorator->addImage($imageUrl);
            }
            $urls->addUrl($imageUrlDecorator, 'gallery');
        }
    }

    public function registerVideoUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $homePageUrl = new UrlConcrete(
            $router->generate(
                'public_index',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            new \DateTime(),
            UrlConcrete::CHANGEFREQ_WEEKLY,
            0.8
        );

        $videoUrlDecorator = new GoogleVideoUrlDecorator($homePageUrl);
        $homepageVideo = new GoogleVideo(
            'https://zorglux-bucket.s3.eu-north-1.amazonaws.com/Booste ton site avec Zorglux Works !.webp',
            'Booste ton site avec Zorglux Works !',
            'Découvrez comment Zorglux Works peut vous aider à améliorer votre site web et à le rendre plus performant. Rejoignez-nous pour une expérience unique et enrichissante.',
            [
                'content_location' => 'https://zorglux-bucket.s3.eu-north-1.amazonaws.com/videos/Booste ton site avec Zorglux Works !.mp4',
                'duration' => 41,
                'rating' => 4.9,
                'publication_date' => new \DateTime('2024-07-01'),
                'family_friendly' => 'yes',
            ]
        );
        $videoUrlDecorator->addVideo($homepageVideo);
        $urls->addUrl($videoUrlDecorator, 'video');

        $aboutUrl = new UrlConcrete(
            $router->generate(
                'public_about',
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            new \DateTime(),
            UrlConcrete::CHANGEFREQ_WEEKLY,
            0.8
        );

        $videoUrlDecorator = new GoogleVideoUrlDecorator($aboutUrl);
        $aboutVideo = new GoogleVideo(
            'https://zorglux-bucket.s3.eu-north-1.amazonaws.com/Booste ton site avec Zorglux Works !.webp',
            'Maîtrisez le SEO avec Zorglux Works!',
            'Découvrez Zorglux en vidéo et apprenez à maîtriser le SEO avec notre plateforme.',
            [
                'content_location' => 'https://zorglux-bucket.s3.eu-north-1.amazonaws.com/videos/Maîtrisez le SEO avec Zorglux Works!.mp4',
                'duration' => 48,
                'rating' => 4.9,
                'publication_date' => new \DateTime('2024-07-01'),
                'family_friendly' => 'yes',
            ]
        );
        $videoUrlDecorator->addVideo($aboutVideo);

        $urls->addUrl($videoUrlDecorator, 'video');


    }
}
