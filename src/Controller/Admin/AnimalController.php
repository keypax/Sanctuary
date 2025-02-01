<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimalController
{
    #[Route('/admin/animal')]
    public function helloworld(): Response
    {
        return new Response('Hello World!');
    }
}