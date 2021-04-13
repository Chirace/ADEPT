<?php 
namespace App\Controller; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NFX35109Controller extends AbstractController {

    public function NFX35109(){
        return $this->render('NFX35109/home.html.twig');
    }
}