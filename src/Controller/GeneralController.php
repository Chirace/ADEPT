<?php 
namespace App\Controller; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeneralController extends AbstractController {

    public function home(){
        return $this->render('general/home.html.twig');
    }

    public function menu(){
        return $this->render('general/menu.html.twig');
    }

    public function formations(){
        return $this->render('general/formations.html.twig');
    }

    public function tools(){
        return $this->render('general/tools.html.twig');
    }

    public function company(){
        return $this->render('general/company.html.twig');
    }

    public function settings(){
        return $this->render('general/settings.html.twig');
    }
}