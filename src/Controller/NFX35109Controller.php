<?php 
namespace App\Controller; 
use App\Entity\Site;
use App\Form\SiteType;
use App\Entity\Fichier;
use App\Entity\Secteur;
use App\Entity\ChargeNFX;
use App\Entity\Operateur;
use App\Entity\Situation;
use App\Form\FichierType;
use App\Form\SecteurType;
use App\Entity\Contrainte;
use App\Entity\Entreprise;
use App\Entity\Evaluateur;
use App\Entity\Evaluation;
use App\Entity\Utilisateur;
use App\Form\ChargeNFXType;
use App\Form\OperateurType;
use App\Form\SituationType;
use App\Form\EntrepriseType;
use App\Form\EvaluateurType;
use App\Entity\EvaluationNFX;
use App\Entity\PosteDeTravail;
use App\Form\PosteDeTravailType;
use App\Form\ContrainteExecutionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NFX35109Controller extends AbstractController {

    public function NFX35109($id){
        return $this->render('NFX35109/home.html.twig', array(
            'idEvaluateur' => $id));
    }
    
    public function activity(){
        return $this->render('NFX35109/activity.html.twig');
    }

    public function operator(){
        return $this->render('NFX35109/operator.html.twig');
    }

    public function activityDetail($id, $id2){

        return $this->render('NFX35109/activityDetail.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2)
        );
    }

    public function handlingType($id, $id2){
        return $this->render('NFX35109/handlingType.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2)
        );
    }

    public function handlingWithoutAssistance($id, $id2){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneBySituation($id2);
        $evaluationNFX = $evaluation->getEvaluationNFX()->getData();
        /*$evaluationNFX = $this->getDoctrine()->getManager()->getRepository(EvaluationNFX::class)
            ->findOneByEvaluation($evaluation);*/
        $charges = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneByEvaluationNfx($evaluationNFX);

        return $this->render('NFX35109/handlingWithoutAssistance.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2,
            'charges' => $charges));
    }

    public function handlingWithoutAssistanceNewCharge(Request $request, EntityManagerInterface $manager, $id, $id2){
        $charge = new ChargeNFX();
        $form = $this->createForm(ChargeNFXType::class, $charge);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $charge->setForceInitiale(0);
            /*$charge->setForceMaintien(0);
            $charge->setPTAction(0);*/
            $charge->setNombreChargeIdentique(1);


            
            $manager->persist($charge);
            $manager->flush($charge);

            $id3 = $charge->getId();

            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_execution_constraint', ['id' => $id, 'id2' => $id2, 'id3' => $id3]);
        }

        return $this->render('NFX35109/handlingWithoutAssistanceChargeInformations.html.twig', array(
            'form' => $form->createView(),
            'idEvaluateur' => $id,
            'idSituation' => $id2));
    }
    
    public function handlingWithoutAssistanceNewChargeConstraint($id, $id2){
        return $this->render('NFX35109/handlingWithoutAssistanceExecutionConstraint.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2));
    }
    
    public function handlingWithoutAssistanceTonnageFrequency($id, $id2){
        return $this->render('NFX35109/handlingWithoutAssistanceTonnageFrequency.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2));
    }
    
    public function handlingWithoutAssistanceNewConstraints($id, $id2){
        return $this->render('NFX35109/handlingWithoutAssistanceNewConstraints.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2));
    }
    
    public function handlingWithoutAssistanceResume($id, $id2){
        return $this->render('NFX35109/handlingWithoutAssistanceResume.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2));
    }
    
    public function handlingWithoutAssistanceResumeCharge($id, $id2){
        return $this->render('NFX35109/handlingWithoutAssistanceResumeCharge.html.twig', array(
            'idEvaluateur' => $id,
            'idSituation' => $id2));
    }

    public function handlingWithAssistance(){
        return $this->render('NFX35109/handlingWithAssistance.html.twig');
    }

    public function execution(){
        return $this->render('NFX35109/execution.html.twig');
    }

    public function references(){
        return $this->render('NFX35109/references.html.twig');
    }

    public function constraints(){
        return $this->render('NFX35109/constraints.html.twig');
    }

    public function results(){
        return $this->render('NFX35109/results.html.twig');
    }

    public function listerContraintesExecution2(Request $request) {
        $contrainteExecution = new Contrainte();
        $form = $this->createForm(ContrainteExecutionType::class, $contrainteExecution);

        $form->handleRequest($request);
        /*if ($form->isValid()) {
            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_execution_constraint');
        }*/

        return $this->render('NFX35109/handlingWithoutAssistanceExecutionConstraint.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listerContraintesExecution(Request $request, $id, $id2) {
        $listeContraintes = $this->getDoctrine()
                   ->getRepository(Contrainte::Class);
        
        $listeContraintesExecution = $listeContraintes->findBy(array('categorie_contrainte' => '1'),
                                                            null,
                                                            null,
                                                            null);

        return $this->render('NFX35109/handlingWithoutAssistanceExecutionConstraint.html.twig', array(
            'listeContraintes' => $listeContraintesExecution,
            'idEvaluateur' => $id,
            'idSituation' => $id2
        ));
    }

    public function listerContraintes(Request $request) {
        $listeContraintes = $this->getDoctrine()
                   ->getRepository(Contrainte::Class);
        
        $listeContraintesEnvironnement = $listeContraintes->findBy(array('categorie_contrainte' => '2'),
                                                            null,
                                                            null,
                                                            null);
        
        $listeContraintesOrganisation = $listeContraintes->findBy(array('categorie_contrainte' => '3'),
                                                            null,
                                                            null,
                                                            null);

        return $this->render('NFX35109/handlingWithoutAssistanceNewConstraints.html.twig', array(
            'listeContraintesEnvironnement' => $listeContraintesEnvironnement,
            'listeContraintesOrganisation' => $listeContraintesOrganisation
        ));
    }

    public function nouvelEvaluateur(Request $request, EntityManagerInterface $manager, UserInterface $user, $id) {
        $utilisateur = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)
            ->findOneByUsername($user->getUsername());

        $evaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findOneById($id);
        
        //$evaluateur = new Evaluateur();
        $entreprise = new Entreprise();
        $site = new Site();
        $secteur = new Secteur();
        $posteDeTravail = new PosteDeTravail();
        $situation = new Situation();

        //$formEvaluateur = $this->createForm(EvaluateurType::class, $evaluateur);
        $formEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        $formSite = $this->createForm(SiteType::class, $site);
        $formSecteur = $this->createForm(SecteurType::class, $secteur);
        $formPosteDeTravail = $this->createForm(PosteDeTravailType::class, $posteDeTravail);
        $formSituation = $this->createForm(SituationType::class, $situation);

        //$formEvaluateur->handleRequest($request);
        $formEntreprise->handleRequest($request);
        $formSite->handleRequest($request);
        $formSecteur->handleRequest($request);
        $formPosteDeTravail->handleRequest($request);
        $formSituation->handleRequest($request);

        /*if ($formEvaluateur->isSubmitted() && $formEvaluateur->isValid()) {
            $manager->persist($evaluateur);
            $manager->flush();
            if ($formEntreprise->isSubmitted() && $formEntreprise->isValid()) {
                $manager->persist($entreprise);
                //$manager->flush();
                if ($formSite->isSubmitted() && $formSite->isValid()) {
                    $manager->persist($site);
                    //$manager->flush();
                    if ($formSecteur->isSubmitted() && $formSecteur->isValid()) {
                        $manager->persist($secteur);
                        //$manager->flush();
                        if ($formPosteDeTravail->isSubmitted() && $formPosteDeTravail->isValid()) {
                            $manager->persist($posteDeTravail);
                            //$manager->flush();
                            if ($formActivite->isSubmitted() && $formActivite->isValid()) {
                                $manager->persist($activite);
                                $manager->flush();
                                return $this->redirectToRoute('adept_NFX35109_picture');
                            }
                        }
                    }
                }
            }
        }*/

        //$evaluateur->setUtilisateur($utilisateur);

        if ($formSituation->isSubmitted() && $formSituation->isValid()) {
            $manager->persist($evaluateur);
            $manager->flush();

            $entreprise->setEvaluateur($evaluateur);
            $manager->persist($entreprise);
            $manager->flush();

            $site->setEntreprise($entreprise);
            $manager->persist($site);
            $manager->flush();

            $secteur->setSite($site);
            $manager->persist($secteur);
            $manager->flush();

            $posteDeTravail->setSecteur($secteur);
            $manager->persist($posteDeTravail);
            $manager->flush();

            //$situation->setPosteDeTravail($posteDeTravail);
            $manager->persist($situation);
            $manager->flush();

            $evaluation = new Evaluation();
            $evaluationNFX = new EvaluationNFX();

            $date = new \DateTime();
            //$date = date('Y-m-d H:i:s');

            $evaluationNFX->setDateEvaluation($date);
            $manager->persist($evaluationNFX);
            $manager->flush();

            $evaluation->setDateEvaluation($date);

            $evaluation->setEvaluateur($evaluateur);
            $evaluation->setSituation($situation);
            $evaluation->setTypeEvaluation('NF X35-109');
            $evaluation->setEvaluationNFX($evaluationNFX);
            $manager->persist($evaluation);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_picture', ['id' => $evaluateur->getId(), 'id2' => $situation->getId()]);
        }

        return $this->render('NFX35109/activity.html.twig', array(
            'evaluateur' => $evaluateur,
            //'formEvaluateur' => $formEvaluateur->createView(),
            'formEntreprise' => $formEntreprise->createView(),
            'formSite' => $formSite->createView(),
            'formSecteur' => $formSecteur->createView(),
            'formPosteDeTravail' => $formPosteDeTravail->createView(),
            'formSituation' => $formSituation->createView(),
        ));
    }

    public function nouvelOperateur(Request $request, $id, $id2) {
        $operateur = new Operateur();
        $form = $this->createForm(OperateurType::class, $operateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('adept_NFX35109_operator', ['id' => $id, 'id2' => $id2]);
        }
        return $this->render('NFX35109/operator.html.twig', array(
            'form' => $form->createView(),
            'idEvaluateur' => $id,
            'idSituation' => $id2
        ));
    }

    public function picture(Request $request, EntityManagerInterface $manager, $id, $id2){
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $fichier->getNomFichier();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->getParameter('upload_directory'), $fileName);

            $fichier->setNomFichier($fileName);
            /*$extension = explode('.', $fileName);
            $fichier->setTypeFichier($extension[$extension]);
            $fichier->setDateFichier(new \DateTime('now'));

            $manager->persist($fichier);
            $manager->flush();*/

            return $this->redirectToRoute('adept_NFX35109_picture', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('NFX35109/picture.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            'id2' => $id2
        ));
    }
}