<?php 
namespace App\Controller; 
use App\Entity\Site;
use App\Form\SiteType;
use App\Entity\Entreprise;
use App\Entity\Evaluateur;
use App\Entity\Evaluation;
use App\Entity\DivisionNAF;
use App\Entity\Utilisateur;
use App\Form\EntrepriseType;
use App\Form\EvaluateurType;
use App\Entity\EvaluationNFX;
use App\Entity\EvaluationED6161;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

    public function deleteEvaluation(Request $request, EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);

        if($evaluation->getTypeEvaluation() == "ED6161"){
            $evaluationED6161 = $this->getDoctrine()->getManager()->getRepository(EvaluationED6161::class)
                ->findOneByEvaluation($evaluation);
            if(isset($evaluationED6161)){
                $manager->remove($evaluationED6161);
            }
        } elseif($evaluation->getTypeEvaluation() == "NF X35-109"){
            $evaluationNFX = $evaluation->getEvaluationNfx();
            $manager->remove($evaluationNFX);
        }
        $manager->remove($evaluation);
        $manager->flush();

        return $this->redirectToRoute('adept_search');
    }

    /*
     Creates a new ActionItem entity.
     
      @Route("/search", name="ajax_search")
     @Method("GET")
     */
    /*public function searchCompany(Request $request){
        $requestString = $request->get('q');

        $entites =  $this->getDoctrine()->getManager()->getRepository(Entreprise::class)
            ->findAllMatching($requestString);
        
        if(!$entites) {
            $result['entites']['error'] = "Aucune entreprise trouvée";
        } else {
            $result['entites'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntites($entites){

        foreach ($entites as $entite){
            $realEntites[$entite->getId()] = $entite->getFoo();
        }
  
        return $realEntites;
    }*/

    public function guide($id){
        /*$idEvaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id)->getEvaluateur()->getId();
        

        return $this->render('general/guide.html.twig', array(
            'idEvaluateur' => $idEvaluateur));*/
        
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);

        return $this->render('general/guide.html.twig', array(
            'evaluation' => $evaluation));
        //return $this->redirectToRoute('adept_tool_guide', ['id' => $id]);
    }

    public function evaluator(Request $request, EntityManagerInterface $manager, UserInterface $user){
        $utilisateur = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)
                        ->findOneByUsername($user->getUsername());

        $evaluateurs = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findByUtilisateur($utilisateur);

        $evaluation = new Evaluation();
        $evaluateur = new Evaluateur();
        //$form = $this->createForm(EvaluateurType::class, $evaluateur);

        $form = $this->createFormBuilder($evaluateur)
            ->add('evaluateurs', EntityType::class, array(
                'class' => Evaluateur::class,
                'required' => false,
                'choice_label' => function ($evaluateurs) {
                    return $evaluateurs->getNom() . ' - ' . $evaluateurs->getPrenom();
                }
            ))
            ->add('nom', null, array(
                'required' => false))
            ->add('prenom', null, array(
                'required' => false))
            ->add('fonction', null, array(
                'required' => false))
            ->add('entreprise', EntrepriseType::class, array(
                'required' => false))
            ->add('site', SiteType::class, array(
                'required' => false))
            ->add('entreprise_exterieure', EntrepriseType::class, array(
                'required' => false))
            ->add('site_exterieur', SiteType::class, array(
                'required' => false))
            ->add('secteur_activite', EntityType::class, array(
                'class' => DivisionNAF::class,
                'required' => false,
                'choice_label' => function ($divisionNAF) {
                    return $divisionNAF->getSectionNAF()->getCode() . ' - ' . $divisionNAF->getCode() . ' - ' . $divisionNAF->getLibelle();
                }
            ))
            ->add('effectif', null, array(
                'required' => false))
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->add('valider2', SubmitType::class, array('label'=> 'Charger'))
            ->getForm();
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('evaluateurs')->getData() != null){
                $evaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
                    ->find($form->get('evaluateurs')->getData()->getId());

                //echo $form->get('evaluateurs')->getData();

                return $this->redirectToRoute('adept_evaluator_choose', ['id' => $evaluateur->getId()]);
            } elseif(($form->get('nom')->getData() != null) and ($form->get('prenom')->getData() != null) and ($form->get('fonction')->getData() != null) and ($form->get('entreprise')->getData() != null) and ($form->get('site')->getData() != null)) {
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
                    $evaluation->setEvaluationInterne(false);

                    $entrepriseExterieure = $form->get('entreprise_exterieure')->getData();
                    $manager->persist($entrepriseExterieure);
                    
                    $evaluateur->setEntreprise($entrepriseExterieure);
                    $evaluation->setEntreprise($entrepriseExterieure);
                    
                    $entrepriseExterieure->setEvaluateur($evaluateur);
                    $entrepriseExterieure->setSecteurActivite($form->get('secteur_activite')->getData());
                    $entrepriseExterieure->setEffectif($form->get('effectif')->getData());
                    $manager->persist($entrepriseExterieure);

                    $siteExterieur = $form->get('site_exterieur')->getData();
                    $siteExterieur->setEntreprise($entrepriseExterieure);
                    $manager->persist($siteExterieur);

                    $evaluation->setSite($siteExterieur);

                    /*$divisionNAFselect = $form->get('secteur_activite')->getData();
                    $evaluateur->setSecteurActivite($divisionNAFselect);
                    $evaluateur->setEffectif($form->get('effectif')->getData());*/
                } else {
                    $evaluation->setEvaluationInterne(true);

                    $evaluation->setEntreprise($entreprise);
                    $evaluation->setSite($site);
                }
                $manager->persist($evaluateur);

                $date = new \DateTime();

                $evaluation->setTypeEvaluation("Non défini");
                $evaluation->setDateEvaluation($date);
                $evaluation->setEvaluateur($evaluateur);

                $manager->persist($evaluation);
                $manager->flush();

                return $this->redirectToRoute('adept_tool_guide', ['id' => $evaluation->getId()]);
            } else {
                return $this->render('general/evaluator.html.twig', array(
                    'form' => $form->createView(),
                    'evaluateurs' => $evaluateurs
                    )
                );
            }
        }

        return $this->render('general/evaluator.html.twig', array(
            'form' => $form->createView(),
            'evaluateurs' => $evaluateurs
            )
        );
    }

    public function evaluatorChoose(Request $request, EntityManagerInterface $manager, UserInterface $user, $id){
        $utilisateur = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)
                        ->findOneByUsername($user->getUsername());

        $evaluateurs = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findByUtilisateur($utilisateur);

        $evaluation = new Evaluation();
        $evaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findOneById($id);

        $form = $this->createFormBuilder($evaluateur)
            ->add('evaluateurs', EntityType::class, array(
                'class' => Evaluateur::class,
                'required' => false,
                'choice_label' => function ($evaluateurs) {
                    return $evaluateurs->getNom() . ' - ' . $evaluateurs->getPrenom();
                }
            ))
            ->add('nom', null, array(
                'required' => false,
                'empty_data' => $evaluateur->getNom()
                ))
            ->add('prenom', null, array(
                'required' => false,
                'empty_data' => $evaluateur->getPrenom()
                ))
            ->add('fonction', null, array(
                'required' => false,
                'empty_data' => $evaluateur->getFonction()
                ))
            ->add('entreprise', EntrepriseType::class, array(
                'required' => false,
                'empty_data' => $evaluateur->getEntreprise()
                ))
            ->add('site', SiteType::class, array(
                'required' => false,
                'empty_data' => $evaluateur->getSite()
                ))
            ->add('entreprise_exterieure', EntrepriseType::class, array(
                'required' => false))
            ->add('site_exterieur', SiteType::class, array(
                'required' => false))
            ->add('secteur_activite', EntityType::class, array(
                'class' => DivisionNAF::class,
                'required' => false,
                'choice_label' => function ($divisionNAF) {
                    return $divisionNAF->getSectionNAF()->getCode() . ' - ' . $divisionNAF->getCode() . ' - ' . $divisionNAF->getLibelle();
                }
            ))
            ->add('effectif', null, array(
                'required' => false))
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->add('valider2', SubmitType::class, array('label'=> 'Charger'))
            ->getForm();
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('evaluateurs')->getData() != null){
                $evaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
                    ->find($form->get('evaluateurs')->getData()->getId());

                //echo $form->get('evaluateurs')->getData();

                return $this->redirectToRoute('adept_evaluator_choose', ['id' => $evaluateur->getId()]);
            } else {
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
                    $evaluation->setEvaluationInterne(false);

                    $entrepriseExterieure = $form->get('entreprise_exterieure')->getData();
                    $manager->persist($entrepriseExterieure);
                    
                    $evaluateur->setEntreprise($entrepriseExterieure);
                    $evaluation->setEntreprise($entrepriseExterieure);
                    
                    $entrepriseExterieure->setEvaluateur($evaluateur);
                    $entrepriseExterieure->setSecteurActivite($form->get('secteur_activite')->getData());
                    $entrepriseExterieure->setEffectif($form->get('effectif')->getData());
                    $manager->persist($entrepriseExterieure);

                    $siteExterieur = $form->get('site_exterieur')->getData();
                    $siteExterieur->setEntreprise($entrepriseExterieure);
                    $manager->persist($siteExterieur);

                    $evaluation->setSite($siteExterieur);

                    /*$divisionNAFselect = $form->get('secteur_activite')->getData();
                    $evaluateur->setSecteurActivite($divisionNAFselect);
                    $evaluateur->setEffectif($form->get('effectif')->getData());*/
                } else {
                    $evaluation->setEvaluationInterne(true);

                    $evaluation->setEntreprise($entreprise);
                    $evaluation->setSite($site);
                }
                $manager->persist($evaluateur);

                $date = new \DateTime();

                $evaluation->setTypeEvaluation("Non défini");
                $evaluation->setDateEvaluation($date);
                $evaluation->setEvaluateur($evaluateur);

                $manager->persist($evaluation);
                $manager->flush();

                return $this->redirectToRoute('adept_tool_guide', ['id' => $evaluation->getId()]);
            }
        }
        return $this->render('general/evaluator.html.twig', array(
            'form' => $form->createView(),
            'evaluateurs' => $evaluateurs
            )
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
                    if(str_contains(strtolower(trim($evaluation->getNom())), strtolower(trim($nom)))) {
                        array_push($listeEvaluations, $evaluation);
                    }
                }
            }
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