<?php

namespace App\Repository;

class GalleryRepository
{
    public static function all(array $options = []): array
    {
        $limit = $options['limit'] ?? -1;
        $images = self::getImages();

        shuffle($images);
        return $limit > 0 ? array_slice($images, 0, $limit) : $images;
    }

    private static function getImages()
    {
        return [
            [
                'src' => 'zorglux-tech-mechanics-logo.webp',
                'alt' => 'Logo des mécaniques technologiques de Zorglux',
                'title' => 'Emblème des mécanismes avancés de Zorglux',
            ],
            [
                'src' => 'zorglux-futuristic-dashboard.webp',
                'alt' => 'Tableau de bord futuriste de Zorglux',
                'title' => 'Interface futuriste du tableau de bord de Zorglux',
            ],
            [
                'src' => 'zorglux-innovative-circuitry-logo.webp',
                'alt' => 'Logo du circuit innovant de Zorglux',
                'title' => 'Design du circuit innovant de Zorglux',
            ],
            [
                'src' => 'zorglux-digital-hub-logo.webp',
                'alt' => 'Logo du hub numérique de Zorglux',
                'title' => 'Emblème du centre numérique de Zorglux',
            ],
            [
                'src' => 'zorglux-giant-z-display.webp',
                'alt' => 'Affichage géant du Z de Zorglux',
                'title' => 'Grande exposition du Z de Zorglux',
            ],
            [
                'src' => 'zorglux-data-center-logo.webp',
                'alt' => 'Logo du centre de données de Zorglux',
                'title' => 'Emblème du centre de données de Zorglux',
            ],
            [
                'src' => 'zorglux-dynamic-logo.webp',
                'alt' => 'Logo dynamique de Zorglux',
                'title' => 'Emblème animé de Zorglux',
            ],
            [
                'src' => 'zorglux-interactive-z-logo.webp',
                'alt' => 'Logo interactif du Z de Zorglux',
                'title' => 'Symbole interactif du Z de Zorglux',
            ],
            [
                'src' => 'zorglux-digital-realm-logo.webp',
                'alt' => 'Logo du royaume numérique de Zorglux',
                'title' => 'Emblème du royaume digital de Zorglux',
            ],
            [
                'src' => 'futuristic-colorful-zorglux-seo-scene.webp',
                'alt' => 'A futuristic and colorful scene featuring the Zorglux logo with elements of SEO and blogging in an exotic, vibrant setting.',
                'title' => 'Futuristic and Colorful Zorglux SEO Scene',
            ],
            [
                'src' => 'futuristic-zorglux-seo-blogging-exotic-scene.webp',
                'alt' => 'A futuristic and colorful scene featuring the Zorglux logo with elements of SEO and blogging in an exotic, vibrant setting with neon lights.',
                'title' => 'Futuristic Zorglux SEO Blogging Exotic Scene',
            ],
            [
                'src' => 'futuristic-zorglux-seo-scene.webp',
                'alt' => 'A futuristic and colorful scene featuring the Zorglux logo with elements of SEO and blogging in an exotic, vibrant setting with a space-themed backdrop.',
                'title' => 'Futuristic Zorglux SEO Scene',
            ],
            [
                'src' => 'futuristic-colorful-zorglux-seo-blogging-scene.webp',
                'alt' => 'A futuristic and colorful scene featuring the Zorglux logo with elements of SEO and blogging in an exotic, vibrant setting with a vintage car and a rocket.',
                'title' => 'Futuristic and Colorful Zorglux SEO Blogging Scene'
            ],
            [
                'src' => 'futuristic-vibrant-zorglux-blogging-scene.webp',
                'alt' => 'A futuristic and colorful scene featuring the Zorglux logo with elements of SEO and blogging in an exotic, vibrant setting.',
                'title' => 'Futuristic and Vibrant Zorglux Blogging Scene'
            ],
            [
                'src' => 'futuristic-exotic-zorglux-seo-scene.webp',
                'alt' => 'A futuristic and colorful scene featuring the Zorglux logo with elements of SEO and blogging in an exotic, vibrant setting with a cozy seating area.',
                'title' => 'Futuristic Exotic Zorglux SEO Scene'
            ],
            [
                'src' => 'futuristic-colorful-zorglux-logo.webp',
                'alt' => 'A futuristic and colorful scene featuring the Zorglux logo with elements of SEO and blogging in an exotic, vibrant setting.',
                'title' => 'Futuristic and Colorful Zorglux Logo Scene'
            ],
            [
                'src' => 'zorglux-blue-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a blue background',
                'title' => 'Zorglux Futuristic Blue Scene for SEO and Blogging',
            ],
            [
                'src' => 'zorglux-red-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a red background',
                'title' => 'Zorglux Futuristic Red Scene for SEO and Blogging',
            ],
            [
                'src' => 'zorglux-green-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a green background',
                'title' => 'Zorglux Futuristic Green Scene for SEO and Blogging',
            ],
            [
                'src' => 'zorglux-yellow-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a yellow background',
                'title' => 'Zorglux Futuristic Yellow Scene for SEO and Blogging',
            ],
            [
                'src' => 'zorglux-purple-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a purple background',
                'title' => 'Zorglux Futuristic Purple Scene for SEO and Blogging',
            ],
            [
                'src' => 'zorglux-pink-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a pink background',
                'title' => 'Zorglux Futuristic Pink Scene for SEO and Blogging',
            ],
            [
                'src' => 'zorglux-turquoise-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a turquoise background',
                'title' => 'Zorglux Futuristic Turquoise Scene for SEO and Blogging',
            ],
            [
                'src' => 'zorglux-brown-seo-blogging-scene.webp',
                'alt' => 'A futuristic scene featuring the Zorglux logo and the theme of SEO and blogging with a brown background',
                'title' => 'Zorglux Futuristic Brown Scene for SEO and Blogging',
            ],
        ];
    }

}
