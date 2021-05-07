<?php 
namespace App\Controller; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeneralController extends AbstractController {

    public function analyzeChoice(){
        return $this->render('general/analyseChoice.html.twig');
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }

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

    public function guide(){
        return $this->render('general/guide.html.twig');
    }
}