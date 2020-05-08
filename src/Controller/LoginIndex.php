<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginIndex extends AbstractController
{
    public function login()
    {
        return $this->render('login_index.html.twig');
    }
}