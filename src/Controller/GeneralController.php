<?php 
namespace App\Controller; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GeneralController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('general/home.html.twig');
    }
}
