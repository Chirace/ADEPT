<?php 
namespace App\Controller; 
use App\Entity\Evaluateur;
use App\Entity\Utilisateur;
use App\Form\EntrepriseType;
use App\Form\EvaluateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

    public function guide($id){
        return $this->render('general/guide.html.twig', array(
            'idEvaluateur' => $id));
        //return $this->redirectToRoute('adept_tool_guide', ['id' => $id]);
    }

    public function evaluator(Request $request, EntityManagerInterface $manager, UserInterface $user){
        $utilisateur = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)
                        ->findOneByUsername($user->getUsername());

        $evaluateur = new Evaluateur();
        $form = $this->createForm(EvaluateurType::class, $evaluateur);

        /*$form = $this->createFormBuilder($evaluateur)
            ->add('nom')
            ->add('prenom')
            ->add('fonction')
            //->add('entreprise', TextType::class, array('label' => false))
            //->add('entreprise', EntrepriseType::class, array('label' => false))
            //->add('site')
            //->add('entreprise_exterieure')
            ->add('site_exterieur')
            ->add('secteur_activite')
            ->add('effectif')
            ->add('valider', SubmitType::class, array('label'=> 'continuer'))
            ->getForm();*/
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /*$entreprise = new Entreprise();
            $entreprise->setNom($form->get('entreprise')->getData());
            $manager->persist($entreprise);*/

            $evaluateur->setUtilisateur($utilisateur);
            //$evaluateur->setEntreprise($entreprise);
            $manager->persist($evaluateur);

            //$entreprise->setEvaluateur($evaluateur);
            //$manager->persist($entreprise);

            $manager->flush();

            return $this->redirectToRoute('adept_tool_guide', ['id' => $evaluateur->getId()]);
        }

        return $this->render('general/evaluator.html.twig', array(
            'form' => $form->createView())
        );
    }
}