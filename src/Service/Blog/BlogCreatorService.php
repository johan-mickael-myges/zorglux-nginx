<?php

namespace App\Service\Blog;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Service\S3\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class BlogCreatorService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileUploaderService $fileUploaderService,
        private BlogRepository $blogRepository,
        private Security $security,
    )
    {
    }

    public function create(Blog $blog): void
    {
        $blog->setAuthor($this->security->getUser());
        $blog->setContent($blog->getContent());

        $slug = (new AsciiSlugger())->slug(strtolower($blog->getTitle()));
        $existingBlogWithSlug = $this->blogRepository->getBySlug($slug);
        $creationDate = new \DateTimeImmutable();
        if ($existingBlogWithSlug) {
            $slug .= '-' . $creationDate->format('Y-m-d-H-i-s');
        }
        $blog->setSlug($slug);

        $blog->setCreatedAt($creationDate);
        $blog->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($blog);

        // if app.env is dev, we don't upload the image to S3
        $imageName = 'https://zorglux-bucket.s3.eu-north-1.amazonaws.com/default/no-image.webp';
        if ($_ENV['APP_ENV'] !== 'dev') {
            $imageName = $this->fileUploaderService
                ->uploadImage($blog->getThumbnailFile(), $blog->getThumbnail())
                ->get('ObjectURL');
        }
        $blog->setThumbnail($imageName);
        $this->entityManager->flush();
    }
}
