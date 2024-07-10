<?php

// src/Service/S3UploaderService.php
namespace App\Service\S3;

use Aws\Result;
use Aws\S3\S3Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class FileUploaderService
{
    private S3Client $s3Client;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->s3Client = new S3Client([
            'region' => 'eu-north-1',
            'credentials' => [
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
            ],
        ]);
    }

    public function uploadImage(File $file, string $fileName): Result
    {
        return $this->s3Client->putObject([
            'Bucket' => 'zorglux-bucket',
            'Key' => $fileName,
            'Body' => fopen($file->getPathname(), 'rb'),
        ]);
    }
}
