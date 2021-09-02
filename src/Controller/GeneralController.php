<?php 
namespace App\Controller; 
use App\Entity\Site;
use App\Entity\Entreprise;
use App\Entity\Evaluateur;
use App\Entity\Evaluation;
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
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $evaluateur->setUtilisateur($utilisateur);

            $entreprise = $form->get('entreprise')->getData();
            //$entreprise->setNom($form->get('entreprise')->getData());
            $manager->persist($entreprise);
            
            $evaluateur->setEntreprise($entreprise);
            
            $entreprise->setEvaluateur($evaluateur);
            $manager->persist($entreprise);

            $evaluateur->setNom($form->get('nom')->getData());
            $evaluateur->setPrenom($form->get('prenom')->getData());
            $evaluateur->setFonction($form->get('fonction')->getData());

            $site = $form->get('site')->getData();
            $site->setEntreprise($entreprise);
            //$site->setNom($form->get('site')->getData());
            $manager->persist($site);

            if($form->get('entreprise_exterieure')->getData() != null) {
                $evaluateur->setEvaluationInterne(false);

                $entrepriseExterieure = $form->get('entreprise_exterieure')->getData();
                //$entrepriseExterieure->setNom($form->get('entreprise_exterieure')->getData());
                $manager->persist($entrepriseExterieure);
                
                $evaluateur->setEntreprise($entrepriseExterieure);
                
                $entrepriseExterieure->setEvaluateur($evaluateur);
                $manager->persist($entrepriseExterieure);

                $siteExterieur = $form->get('site_exterieur')->getData();
                $siteExterieur->setEntreprise($entreprise);
                //$siteExterieur->setNom($form->get('site_exterieur')->getData());
                $manager->persist($siteExterieur);

                $divisionNAFselect = $form->get('secteur_activite')->getData();

                /*$divisionNAF = $this->getDoctrine()->getManager()->getRepository(DivisionNAF::class)
                    ->findOneByCode($divisionNAFselect);*/

                $evaluateur->setSecteurActivite($divisionNAFselect);
                
                $evaluateur->setEffectif($form->get('effectif')->getData());
            } else {
                $evaluateur->setEvaluationInterne(true);
            }

            $manager->persist($evaluateur);
            $manager->flush();

            return $this->redirectToRoute('adept_tool_guide', ['id' => $evaluateur->getId()]);
        }

        return $this->render('general/evaluator.html.twig', array(
            'form' => $form->createView())
        );
    }

    public function recherche(Request $request, EntityManagerInterface $manager, UserInterface $user){
        $utilisateur = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)
            ->findOneByUsername($user->getUsername());
        $evaluateurs = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findByUtilisateur($utilisateur);
        $evaluations = null;
        $listeEvaluations = array();

        foreach($evaluateurs as $evaluateur){
            $evaluations = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
                ->findByEvaluateur($evaluateur);
                foreach($evaluations as $evaluation){
                    array_push($listeEvaluations, $evaluation);
                }
        }

        $evaluation = new Evaluation();

        $form = $this->createFormBuilder($evaluation)
            ->add('nom')
            ->add('valider', SubmitType::class, array('label'=> 'Rechercher'))
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();

            $listeEvaluations = array();
            foreach($evaluateurs as $evaluateur){
                $evaluations = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
                    ->findByEvaluateur($evaluateur);
                foreach($evaluations as $evaluation){
                    if((strtolower(trim($evaluation->getNom()))) == (strtolower(trim($nom)))){
                        array_push($listeEvaluations, $evaluation);
                    }
                }
            }

            //return $this->redirectToRoute('adept_search');
            return $this->render('general/search.html.twig', array(
                'form' => $form->createView(),
                'evaluations' => $evaluations,
                'listeEvaluations' => $listeEvaluations
            ));
        }

        return $this->render('general/search.html.twig', array(
            'form' => $form->createView(),
            'evaluations' => $evaluations,
            'listeEvaluations' => $listeEvaluations
        ));
    }
}