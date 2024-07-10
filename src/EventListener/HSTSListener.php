<?php

namespace App\EventListener;

class HSTSListener
{
    public function onKernelResponse($event)
    {
        $response = $event->getResponse();
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }
}
