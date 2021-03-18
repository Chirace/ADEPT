<?php 
namespace App\Controller; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeneralController extends AbstractController {

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('general/home.html.twig');
    }

    /**
     * @Route("/menu", name="menu")
     */
    public function menu(){
        return $this->render('general/menu.html.twig');
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function formations(){
        return $this->render('general/formations.html.twig');
    }

    /**
     * @Route("/tools", name="tools")
     */
    public function tools(){
        return $this->render('general/tools.html.twig');
    }

    /**
     * @Route("/company", name="company")
     */
    public function company(){
        return $this->render('general/company.html.twig');
    }

    /**
     * @Route("/settings", name="settings")
     */
    public function settings(){
        return $this->render('general/settings.html.twig');
    }
}