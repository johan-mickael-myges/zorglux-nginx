<?php

namespace App\Naming;

use Symfony\Component\String\Slugger\AsciiSlugger;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class BlogThumbnailNamer implements NamerInterface
{
    public function name(object $object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);
        $extension = $file->guessExtension();
        $titleSlug = (new AsciiSlugger())->slug($object->getTitle());

        return sprintf(
            '%s-%s.%s',
            $titleSlug,
            time(),
            $extension
        );
    }
}
