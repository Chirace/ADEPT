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
use App\Form\EvaluationType;
use App\Entity\EvaluationNFX;
use App\Entity\PosteDeTravail;
use App\Entity\EvaluationED6161;
use App\Form\PosteDeTravailType;
use App\Form\ContrainteExecutionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NFX35109Controller extends AbstractController {

    public function NFX35109($id){
        return $this->render('NFX35109/home.html.twig', array(
            'id' => $id));
    }

    public function NFX35109FromED6161(Request $request, EntityManagerInterface $manager, $id, $id2){
        $evaluationED6161 = $this->getDoctrine()->getManager()->getRepository(EvaluationED6161::class)
            ->findOneById($id);
        $evaluationBase = $evaluationED6161->getEvaluation();
        $situation = $this->getDoctrine()->getManager()->getRepository(Situation::class)
            ->findOneById($id2);

        $evaluation = new Evaluation();
        $evaluationNFX = new EvaluationNFX();
        $date = new \DateTime();

        $evaluationNFX->setDateEvaluation($date);
        $manager->persist($evaluationNFX);

        $evaluation->setDateEvaluation($date);
        $evaluation->setEvaluationED6161($evaluationED6161);
        $evaluation->setTypeEvaluation("NF X35-109");
        $evaluation->setSituation($situation);
        $evaluation->setEntreprise($evaluationBase->getEntreprise());
        $evaluation->setSite($evaluationBase->getSite());
        $evaluation->setSecteur($evaluationED6161->getSecteur());
        $evaluation->setPosteDeTravail($evaluationED6161->getPosteDeTravail());
        $evaluation->setEvaluationInterne($evaluationBase->getEvaluationInterne());
        $evaluation->setEvaluationNfx($evaluationNFX);
        $evaluation->setEvaluateur($evaluationBase->getEvaluateur());
        $manager->persist($evaluation);
        $manager->flush();

        return $this->render('NFX35109/home.html.twig', array('id' => $evaluation->getId()));
    }
    
    public function activity(){
        return $this->render('NFX35109/activity.html.twig');
    }

    public function operator(){
        return $this->render('NFX35109/operator.html.twig');
    }

    public function activityDetail(Request $request, EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        
        $situation = $evaluation->getSituation();
        $operateur = $situation->getOperateur();

        $form = $this->createForm(SituationType::class, $situation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $situation->setQuoi($form->get('quoi')->getData());
            //$situation->setPourquoi($form->get('pourquoi')->getData());
            $situation->setComment($form->get('comment')->getData());
            $situation->setAvecQui($form->get('avec_qui')->getData());
            $situation->setAvecQuoi($form->get('avec_quoi')->getData());
            $situation->setDimensionTemporelle($form->get('dimension_temporelle')->getData());
            $situation->setAutre($form->get('autre')->getData());
            $situation->setOperateur($operateur);

            $manager->persist($situation);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_manutention_type', ['id' => $id]);
        }
        return $this->render('NFX35109/activityDetail.html.twig', array(
            'idEvaluation' => $id,
            'form' => $form->createView()
            )
        );
    }

    public function handlingType($id){
        return $this->render('NFX35109/handlingType.html.twig', array(
            'idEvaluation' => $id
        ));
    }

    public function handlingWithoutAssistance(EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $this->getDoctrine()->getManager()->getRepository(EvaluationNFX::class)
            ->findOneById($evaluation->getEvaluationNFX());

        $evaluationNFX->setTypeManutention('Sans aide à la manutention');

        $manager->persist($evaluationNFX);
        $manager->flush($evaluationNFX);

        $listeCharges = $this->getDoctrine()->getRepository(ChargeNFX::Class);
 
        $charges = $listeCharges->findBy(array('evaluation_nfx' => $evaluationNFX->getId()),
                                                     null,
                                                     null,
                                                     null);
        
        /*$charges = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findByEvaluationNfx($evaluationNFX);*/

        return $this->render('NFX35109/handlingWithoutAssistance.html.twig', array(
            'idEvaluation' => $id,
            /*'idEvaluateur' => $id,
            'idSituation' => $id2*/
            'charges' => $charges));
    }

    public function handlingWithoutAssistanceNewCharge(Request $request, EntityManagerInterface $manager, $id){
        $charge = new ChargeNFX();
        $form = $this->createForm(ChargeNFXType::class, $charge);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $charge->setForceInitiale(0);
            /*$charge->setForceMaintien(0);
            $charge->setPTAction(0);*/
            $charge->setNombreChargeIdentique(1);

            $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
                ->findOneById($id);
            $evaluationNFX = $evaluation->getEvaluationNFX();
            $charge->setEvaluationNfx($evaluationNFX);

            $manager->persist($charge);
            $manager->flush($charge);

            $id2 = $charge->getId();
            //$id3 = $charge->getId();

            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_execution_constraint', ['id' => $id, 'id2' => $id2]);

            //return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_execution_constraint', ['id' => $id, 'id2' => $id2, 'id3' => $id3]);
        }

        return $this->render('NFX35109/handlingWithoutAssistanceChargeInformations.html.twig', array(
            'form' => $form->createView(),
            'idEvaluation' => $id
            /*'idEvaluateur' => $id,
            'idSituation' => $id2*/
            )
        );
    }

    public function handlingWithoutAssistanceEditCharge(Request $request, EntityManagerInterface $manager, $id, $id2){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $evaluationNFX = $charge->getEvaluationNFX();

        $form = $this->createForm(ChargeNFXType::class, $charge);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $charge->setForceInitiale(0);
            $charge->setNombreChargeIdentique(1);

            $evaluationNFX = $evaluation->getEvaluationNFX();
            $charge->setEvaluationNfx($evaluationNFX);

            $manager->persist($charge);
            $manager->flush($charge);

            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_execution_constraint', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('NFX35109/handlingWithoutAssistanceChargeInformations.html.twig', array(
            'form' => $form->createView(),
            'idEvaluation' => $id
            )
        );
    }

    public function handlingWithoutAssistanceDeleteCharge(Request $request, EntityManagerInterface $manager, $id, $id2){
        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $evaluationNFX = $charge->getEvaluationNfx();

        $manager->remove($charge);
        $manager->flush($charge);

        $listeCharges = $this->getDoctrine()->getRepository(ChargeNFX::Class);
        $charges = $listeCharges->findBy(array('evaluation_nfx' => $evaluationNFX->getId()),
                                                     null,
                                                     null,
                                                     null);
        
        return $this->render('NFX35109/handlingWithoutAssistance.html.twig', array(
            'idEvaluation' => $id,
            'charges' => $charges)
        );
    }
    
    public function handlingWithoutAssistanceNewChargeConstraint($id){
        return $this->render('NFX35109/handlingWithoutAssistanceExecutionConstraint.html.twig', array(
            'idEvaluation' => $id
            /*'idEvaluateur' => $id,
            'idSituation' => $id2*/
            ));
    }
    
    public function handlingWithoutAssistanceTonnageFrequency(Request $request, EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        
        $evaluationNFX = $this->getDoctrine()->getManager()->getRepository(EvaluationNFX::class)
            ->findOneById($evaluation->getEvaluationNfx());

        $form = $this->createFormBuilder($evaluationNFX)
            ->add('temps_tonnage')
            ->add('tonnage')
            ->add('valider', SubmitType::class, array('label'=> 'continuer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($evaluationNFX);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_constraints', ['id' => $id]);
        }

        return $this->render('NFX35109/handlingWithoutAssistanceTonnageFrequency.html.twig', array(
            'idEvaluation' => $id,
            'form' => $form->createView()
        ));
    }
    
    public function handlingWithoutAssistanceNewConstraints(Request $request, EntityManagerInterface $manager, $id){
        $form = $this->createFormBuilder($TypeDocument)
            ->add('valider', SubmitType::class, array('label'=> 'modifier'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_resume', ['id' => $id]);
        }

        return $this->render('NFX35109/handlingWithoutAssistanceNewConstraints.html.twig', array(
            'idEvaluation' => $id
            /*'idEvaluateur' => $id,
            'idSituation' => $id2*/
            ));
    }
    
    public function handlingWithoutAssistanceResume(Request $request, EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $evaluation->getEvaluationNFX();

        $listeCharges = $this->getDoctrine()->getRepository(ChargeNFX::Class);
 
        $charges = $listeCharges->findBy(array('evaluation_nfx' => $evaluationNFX->getId()),
                                                     null,
                                                     null,
                                                     null);

        /* Calcul des coefficients de correction et de la masse corrigée pour chacune des charges */
        foreach($charges as $charge) {
            /* Initialisation des valeurs par défaut et de la valeur de référence */
            $coef_correction1 = 1;
            $coef_correction2 = 1;
            $masse_corrigee = 15;
            $intitule_coef_correction1 = "";
            $intitule_coef_correction2 = "";

            /* Hauteur d'application de l'effort */
            if((0.75 <= $charge->getPriseHauteur()) && ($charge->getPriseHauteur() <= 1.1)) {
                /* Conditions acceptables */
            } elseif((( 0.4 <= $charge->getPriseHauteur()) && ($charge->getPriseHauteur() < 0.75)) || (( 1.1 < $charge->getPriseHauteur()) && ($charge->getPriseHauteur() <= 1.4))) {
                /* Conditions sous contraintes */
                $coef_correction2 = 0.8;
                $intitule_coef_correction2 = "Hauteur de prise";
            } else {
                /* Conditions particulières */
                $coef_correction2 = 0.4;
                $intitule_coef_correction2 = "Hauteur de prise";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Distance de déplacement */
            if($charge->getDistanceTransportCharge() <= 2) {
                /* Conditions acceptables distance inférieure à 2 mètres */
            } elseif (( 2 <= $charge->getDistanceTransportCharge()) && ($charge->getDistanceTransportCharge() < 5)) {
                /* Entre 2 et 5 mètres */
                $coef_correction2 = 0.8;
                $intitule_coef_correction2 = "Distance de déplacement";
            } elseif (( 5 <= $charge->getDistanceTransportCharge()) && ($charge->getDistanceTransportCharge() < 10)) {
                /* Entre 5 et 10 mètres */
                $coef_correction2 = 0.6;
                $intitule_coef_correction2 = "Distance de déplacement";
            } else {
                /* Supérieure à 10 mètres */
                $coef_correction2 = 0.2;
                $intitule_coef_correction2 = "Distance de déplacement";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* OK */

            /* Conditions d'éxecution de la tâche */
            $nb_contraintes_execution = $charge->getContraintesExecution();
            if(strlen(trim($nb_contraintes_execution)) == 0) {
                /* Aucun facteur défavorable */
            } elseif ((strlen(trim($nb_contraintes_execution)) == 1) && ($coef_correction2 > 0.8)) {
                /* Un facteur défavorable */
                $coef_correction2 = 0.8;
                $intitule_coef_correction2 = "Contraintes d'exécution";
            } elseif ((strlen(trim($nb_contraintes_execution)) > 1) && ($coef_correction2 > 0.7)) {
                /* Plusieurs facteurs défavorables */
                $coef_correction2 = 0.7;
                $intitule_coef_correction2 = "Contraintes d'exécution";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Conditions d'environnement de la tâche */
            $nb_contraintes_environnement = $evaluationNFX->getContraintesEnvironnement();
            if(strlen(trim($nb_contraintes_environnement)) == 0) {
                /* Aucun facteur défavorable */
            } elseif ((strlen(trim($nb_contraintes_environnement)) == 2) && ($coef_correction2 > 0.8)) {
                /* Un facteur défavorable */
                $coef_correction2 = 0.8;
                $intitule_coef_correction2 = "Contraintes d'environnement";
            } elseif ((strlen(trim($nb_contraintes_environnement)) > 2) && ($coef_correction2 > 0.7)) {
                /* Plusieurs facteurs défavorables */
                $coef_correction2 = 0.7;
                $intitule_coef_correction2 = "Contraintes d'environnement";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Conditions d'organisation de la tâche */
            $nb_contraintes_organisation = $evaluationNFX->getContraintesOrganisation();
            if(strlen(trim($nb_contraintes_organisation)) == 0) {
                /* Aucun facteur défavorable */
            } elseif ((strlen(trim($nb_contraintes_organisation)) >= 1) && ($coef_correction2 > 0.9)) {
                /* Un ou plusieurs facteurs défavorables */
                $coef_correction2 = 0.9;
                $intitule_coef_correction2 = "Contraintes d'organisation";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Transport de charge (mains) */
            if((trim($charge->getTransportCharge()) == trim("Une main")) && ($coef_correction2 > 0.6)) {
                /* Transport à une main */
                $coef_correction2 = 0.6;
                $intitule_coef_correction2 = "Transport à une main";
            } else {
                /* Transport à deux main */
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            $masse_corrigee = $masse_corrigee * $coef_correction1 *$coef_correction2;

            $charge->setCoefficientCorrection1($coef_correction1);
            $charge->setCoefficientCorrection2($coef_correction2);
            $charge->setMasseCorrigee($masse_corrigee);
            $charge->setIntituleCoefficientCorrection1($intitule_coef_correction1);
            $charge->setIntituleCoefficientCorrection2($intitule_coef_correction2);

            $manager->persist($charge);
            $manager->flush();
        }

        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);

        $form = $this->createFormBuilder($evaluation)
            ->add('nom')
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();

            $evaluation->setNom($nom);

            $manager->persist($evaluation);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_resume', ['id' => $id]);
        }
        
        return $this->render('NFX35109/handlingWithoutAssistanceResume.html.twig', array(
            'idEvaluation' => $id,
            'evaluation' => $evaluation,
            'charges' => $charges,
            'form' => $form->createView()
        ));
    }
    
    public function handlingWithoutAssistanceResumeCharge($id, $id2){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $evaluation->getEvaluationNFX();
        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $ContraintesExecution = $charge->getContraintesExecution();
        $ContraintesEnvironnement = $evaluationNFX->getContraintesEnvironnement();
        $ContraintesOrganisation = $evaluationNFX->getContraintesOrganisation();

        /* Stockage du nombre de contraintes d'exécutions, d'environnements et d'organisations */
        if(empty($ContraintesExecution)){
            $nbContraintesExecution = 0;
        } else {
            $nbContraintesExecution = (strlen(trim($ContraintesExecution)) + 1)/2;
        }

        if(empty($ContraintesEnvironnement)){
            $nbContraintesEnvironnement = 0;
        } else {
            $nbContraintesEnvironnement = (strlen(trim($ContraintesEnvironnement)) + 1)/3;
        }

        if(empty($ContraintesOrganisation)){
            $nbContraintesOrganisation = 0;
        } else {
            $nbContraintesOrganisation = (strlen(trim($ContraintesOrganisation)) + 1)/3;
        }

        /* On identifie les contraintes d'exécutions, d'environnements et d'organisations de la tâche */
        /* On commence par les contraintes d'exécutions */
        $contraintes = explode(",", $ContraintesExecution);
        //for($i = 0; $i <= $nbContraintesExecution; $i++) {
        foreach($contraintes as $contrainte) {
            switch($contrainte){
                case 1:
                    $charge->setContraintePoigneesInadaptees(true);
                    break;
                case 2:
                    $charge->setContrainteTorsionTronc(true);
                    break;
                case 3:
                    $charge->setContrainteProfondeurPrise(true);
                    break;
                case 4:
                    $charge->setContrainteHorsZoneAtteinte(true);
                    break;
                case 5:
                    $charge->setContraintePosture(true);
                    break;
                case 6:
                    $charge->setContrainteChargeInstable(true);
                    break;
                case 7:
                    $charge->setContrainteVisibiliteLimitee(true);
                    break;
                case 8:
                    $charge->setContrainteRoulettesInadequates(true);
                    break;
                case 9:
                    $charge->setContrainteAbsenceFrein(true);
                    break;
            }
        }
        /* On poursuit avec les contraintes d'environnements */
        $contraintes = explode(",", $ContraintesEnvironnement);
        //for($i = 0; $i <= $nbContraintesEnvironnement; $i++) {
        foreach($contraintes as $contrainte) {
            switch($contrainte){
                case 10:
                    $evaluationNFX->setContraintesThermiques(true);
                    break;
                case 11:
                    $evaluationNFX->setContraintesAcoustiques(true);
                    break;
                case 12:
                    $evaluationNFX->setContraintesLumineuses(true);
                    break;
                case 13:
                    $evaluationNFX->setContrainteVibrations(true);
                    break;
                case 14:
                    $evaluationNFX->setContraintePoussieres(true);
                    break;
                case 15:
                    $evaluationNFX->setContrainteSolsDegrades(true);
                    break;
                case 16:
                    $evaluationNFX->setContrainteEncombrement(true);
                    break;
                case 17:
                    $evaluationNFX->setContrainteObstacles(true);
                    break;
                case 18:
                    $evaluationNFX->setContrainteEspacesInadequats(true);
                    break;
                case 19:
                    $evaluationNFX->setContrainteEtatChariot(true);
                    break;
            }
        }
        /* On finit avec les contraintes d'organisations */
        $contraintes = explode(",", $ContraintesOrganisation);
        //for($i = 0; $i <= $nbContraintesOrganisation; $i++) {
        foreach($contraintes as $contrainte) {
            switch($contrainte){
                case 20:
                    $evaluationNFX->setContrainteTemps(true);
                    break;
                case 21:
                    $evaluationNFX->setContrainteMargeManoeuvreReduite(true);
                    break;
                case 22:
                    $evaluationNFX->setContrainteMultipliciteTaches(true);
                    break;
                case 23:
                    $evaluationNFX->setContrainteExigencesQualite(true);
                    break;
            }
        }

        return $this->render('NFX35109/handlingWithoutAssistanceResumeCharge.html.twig', array(
            'idEvaluation' => $id,
            'charge' => $charge,
            'evaluationNFX' => $evaluationNFX,
            'nbContraintesExecution' => $nbContraintesExecution,
            'nbContraintesEnvironnement' => $nbContraintesEnvironnement,
            'nbContraintesOrganisation' => $nbContraintesOrganisation
            /*'idEvaluateur' => $id,
            'idSituation' => $id2*/
            ));
    }

    public function handlingWithAssistance(EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $this->getDoctrine()->getManager()->getRepository(EvaluationNFX::class)
            ->findOneById($evaluation->getEvaluationNFX());

        $evaluationNFX->setTypeManutention('Avec aide à la manutention');

        $manager->persist($evaluationNFX);
        $manager->flush($evaluationNFX);

        $listeCharges = $this->getDoctrine()->getRepository(ChargeNFX::Class);
 
        $charges = $listeCharges->findBy(array('evaluation_nfx' => $evaluationNFX->getId()),
                                                     null,
                                                     null,
                                                     null);

        return $this->render('NFX35109/handlingWithAssistance.html.twig', array(
            'idEvaluation' => $id,
            'charges' => $charges));
    }

    
    public function handlingWithAssistanceType(Request $request, EntityManagerInterface $manager, $id){
        /*$form = $this->createFormBuilder($charge)
            ->add('PT_lit')
            ->add('PT_transpalette')
            ->add('PT_chariot')
            ->getForm();*/

        /*$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
                ->findOneById($id);
            $evaluationNFX = $evaluation->getEvaluationNFX();
            $charge->setEvaluationNfx($evaluationNFX);

            if($type == 1) {
                // Manutention de lit d'hôpital simple 
                $charge->setPTManutentionType("Lit");
            } elseif($type == 2) {
                // Manutention de transpalette 
                $charge->setPTManutentionType("Transpalette");
            } elseif($type == 3) {
                // Manutention de chariot à 4 roues 
                $charge->setPTManutentionType("Chariot");
            } else {
                // Rien 
                $charge->setPTManutentionType("Inconnu");
            }


            $manager->persist($charge);
            $manager->flush($charge);

            $id2 = $charge->getId();

            return $this->redirectToRoute('adept_NFX35109_handling_with_assistance_charge_informations', ['id' => $id, 'id2' => $id2]);
        }*/

        return $this->render('NFX35109/handlingWithAssistanceType.html.twig', array(
            //'form' => $form->createView(),
            'idEvaluation' => $id
            ));
    }

    public function handlingWithAssistanceNewCharge(Request $request, EntityManagerInterface $manager, $id, $type){
        /*$charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);*/

        $charge = new ChargeNFX();

        $form = $this->createFormBuilder($charge)
        ->add('poids_charge')
        ->add('transport_charge', ChoiceType::class, array(
            'choices'  => array(
                'Une main' => 'Une main', 
                'Deux mains' => 'Deux mains'
            ),
        ))
        ->add('PT_action', ChoiceType::class, array(
            'choices'  => array(
                'Pousser' => 'Pousser', 
                'Tirer' => 'Tirer'
            ),
        ))
        ->add('PT_distance')
        ->add('PT_hauteur_poignee')
        ->add('PT_frequence', ChoiceType::class, array(
            'choices'  => array(
                '2/min' => '2/min', 
                '1/min' => '1/min',
                '1/5min' => '1/5min', 
                '1/h' => '1/h'
            ),
        ))
        ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
                ->findOneById($id);
            $evaluationNFX = $evaluation->getEvaluationNFX();
            $charge->setEvaluationNfx($evaluationNFX);

            if($type == 1) {
                $charge->setPTManutentionType("lit");
            } elseif ($type == 2) {
                $charge->setPTManutentionType("transpalette");
            } elseif ($type == 3) {
                $charge->setPTManutentionType("chariot");
            }
            
            $charge->setPoidsCharge($form->get('poids_charge')->getData());
            $charge->setTransportCharge($form->get('transport_charge')->getData());
            $charge->setPTAction($form->get('PT_action')->getData());
            $charge->setPTDistance($form->get('PT_distance')->getData());
            $charge->setPTHauteurPoignee($form->get('PT_hauteur_poignee')->getData());
            $charge->setPTFrequence($form->get('PT_frequence')->getData());
            $charge->setNombreChargeIdentique(1);

            if($charge->getPTFrequence() == "2/min") {
                $charge->setForceInitiale(12);
                $charge->setForceMaintien(6);
            } elseif ($charge->getPTFrequence() == "1/min") {
                $charge->setForceInitiale(16);
                $charge->setForceMaintien(8);
            } elseif ($charge->getPTFrequence() == "1/5min") {
                $charge->setForceInitiale(19);
                $charge->setForceMaintien(9);
            } elseif ($charge->getPTFrequence() == "1/h") {
                $charge->setForceInitiale(21);
                $charge->setForceMaintien(10);
            }

            $manager->persist($charge);
            $manager->flush($charge);

            $id2 = $charge->getId();

            return $this->redirectToRoute('adept_NFX35109_handling_with_assistance_execution_constraint', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('NFX35109/handlingWithAssistanceChargeInformations.html.twig', array(
            'form' => $form->createView(),
            'idEvaluation' => $id,
            'type' => $type
        ));
    }

    public function listerContraintesExecution2(Request $request, EntityManagerInterface $manager, $id, $id2) {
        $listeContraintes = $this->getDoctrine()
                   ->getRepository(Contrainte::Class);
        
        $listeContraintesExecution = $listeContraintes->findBy(array('categorie_contrainte' => '1'),
                                                            null,
                                                            null,
                                                            null);
        
        //unset($listeContraintesExecution[3]);

        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $type = 0;
        if($charge->getPTManutentionType() == "lit"){
            $type = 1;
        } elseif ($charge->getPTManutentionType() == "transpalette"){
            $type = 2;
        } elseif ($charge->getPTManutentionType() == "chariot"){
            $type = 3;
        }

        $form = $this->createFormBuilder($charge)
            ->add('contrainte_poignees_inadaptees', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Sans poignées ou inadaptées',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_torsion_tronc', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                ),
                'label' => 'Torsion du tronc',
                'label_attr' => ['class' => ' row switch2 custom-switch'],
                'required' => true))
            ->add('contrainte_profondeur_prise', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                ),
                'label' => 'Profondeur de prise > 0,40m',
                'label_attr' => ['class' => ' row switch2 custom-switch'],
                'required' => true))
            ->add('contrainte_hors_zone_atteinte', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Hors zone d\'atteinte',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_posture', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Une ou plusieurs contraintes concernant la posture du corps',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_charge_instable', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Charge instable',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_visibilite_limitee', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Visibilité limitée',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_roulettes_inadequates', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                ),
                'label' => 'Roulettes inadéquates',
                'label_attr' => ['class' => ' row switch2 custom-switch'],
                'required' => true))
            ->add('contrainte_absence_frein', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                ),
                'label' => 'Absence de frein',
                'label_attr' => ['class' => ' row switch2 custom-switch'],
                'required' => true))
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contrainte1 = $form->get('contrainte_poignees_inadaptees')->getData();
            $contrainte2 = $form->get('contrainte_torsion_tronc')->getData();
            //$contrainte3 = $form->get('contrainte_profondeur_prise')->getData();
            $contrainte4 = $form->get('contrainte_hors_zone_atteinte')->getData();
            $contrainte5 = $form->get('contrainte_posture')->getData();
            $contrainte6 = $form->get('contrainte_charge_instable')->getData();
            $contrainte7 = $form->get('contrainte_visibilite_limitee')->getData();
            $contrainte8 = $form->get('contrainte_roulettes_inadequates')->getData();
            $contrainte9 = $form->get('contrainte_absence_frein')->getData();

            // Faire une boucle, mettre les contraintes dans une liste et bouclé dessus pour mettre des , où c'est nécessaire.
            $chaine_contraintes = "";
            $numero = 0;
            $contraintes = array($contrainte1, $contrainte2, $contrainte4, $contrainte5, $contrainte6, $contrainte7, $contrainte8, $contrainte9);
            foreach($contraintes as $contrainte) {
                $numero += 1;
                if ($contrainte == true){
                    if((strlen($chaine_contraintes))%2 == 1 ) {
                        $chaine_contraintes = $chaine_contraintes.",";
                    }
                    $chaine_contraintes = $chaine_contraintes.$numero;
                }
            }
            
            $charge->setContraintesExecution($chaine_contraintes);

            $manager->persist($charge);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_handling_with_assistance', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('NFX35109/handlingWithAssistanceExecutionConstraint.html.twig', array(
            'listeContraintes' => $listeContraintesExecution,
            'idEvaluateur' => $id,
            'idSituation' => $id2,
            'type' => $type,
            'form' => $form->createView()
        ));
    }

    /* incomplète */
    public function handlingWithAssistanceEditCharge(Request $request, EntityManagerInterface $manager, $id, $id2){
        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $evaluationNFX = $charge->getEvaluationNFX();

        $type = 0;
        if($charge->getPTManutentionType() == "lit"){
            $type = 1;
        } elseif ($charge->getPTManutentionType() == "transpalette"){
            $type = 2;
        } elseif ($charge->getPTManutentionType() == "chariot"){
            $type = 3;
        }

        return $this->redirectToRoute('adept_NFX35109_handling_with_assistance_charge_informations', ['id' => $id, 'type' => $type]);
    }

    public function handlingWithAssistanceDeleteCharge(Request $request, EntityManagerInterface $manager, $id, $id2){
        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $evaluationNFX = $charge->getEvaluationNfx();

        $manager->remove($charge);
        $manager->flush($charge);

        $listeCharges = $this->getDoctrine()->getRepository(ChargeNFX::Class);
        $charges = $listeCharges->findBy(array('evaluation_nfx' => $evaluationNFX->getId()),
                                                     null,
                                                     null,
                                                     null);
        
        return $this->render('NFX35109/handlingWithAssistance.html.twig', array(
            'idEvaluation' => $id,
            'charges' => $charges)
        );
    }

    public function handlingWithAssistanceTonnageFrequency(Request $request, EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        
        $evaluationNFX = $this->getDoctrine()->getManager()->getRepository(EvaluationNFX::class)
            ->findOneById($evaluation->getEvaluationNfx());

        $form = $this->createFormBuilder($evaluationNFX)
            ->add('temps_tonnage')
            ->add('tonnage')
            ->add('valider', SubmitType::class, array('label'=> 'continuer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($evaluationNFX);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_handling_with_assistance_constraints', ['id' => $id]);
        }

        return $this->render('NFX35109/handlingWithAssistanceTonnageFrequency.html.twig', array(
            'idEvaluation' => $id,
            'form' => $form->createView()
        ));
    }

    public function listerContraintes2(Request $request, EntityManagerInterface $manager, $id) {
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
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $evaluation->getEvaluationNFX();

        $form = $this->createFormBuilder($evaluationNFX)
        ->add('contraintes_thermiques', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes thermiques',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contraintes_acoustiques', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes acoustiques',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contraintes_lumineuses', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes lumineuses',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_vibrations', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Vibrations',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_poussieres', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Poussières',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_sols_degrades', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Sols dégradés',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_encombrement', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Encombrement',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_obstacles', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Obstacles',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_espaces_inadequats', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Espaces inadéquats pour manœuvrer',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_etat_chariot', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'État du chariot',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_temps', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes de temps',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_marge_manoeuvre_reduite', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Marge de manoeuvre réduite',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_multiplicite_taches', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Multiplicité des tâches',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_exigences_qualite', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Exigences qualité',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contrainte10 = $form->get('contraintes_thermiques')->getData();
            $contrainte11 = $form->get('contraintes_acoustiques')->getData();
            $contrainte12 = $form->get('contraintes_lumineuses')->getData();
            $contrainte13 = $form->get('contrainte_vibrations')->getData();
            $contrainte14 = $form->get('contrainte_poussieres')->getData();
            $contrainte15 = $form->get('contrainte_sols_degrades')->getData();
            $contrainte16 = $form->get('contrainte_encombrement')->getData();
            $contrainte17 = $form->get('contrainte_obstacles')->getData();
            $contrainte18 = $form->get('contrainte_etat_chariot')->getData();
            $contrainte18 = $form->get('contrainte_espaces_inadequats')->getData();
            $contrainte20 = $form->get('contrainte_temps')->getData();
            $contrainte21 = $form->get('contrainte_marge_manoeuvre_reduite')->getData();
            $contrainte22 = $form->get('contrainte_multiplicite_taches')->getData();
            $contrainte23 = $form->get('contrainte_exigences_qualite')->getData();

            // Faire une boucle, mettre les contraintes dans une liste et bouclé dessus pour mettre des , où c'est nécessaire.
            $chaine_contraintes_environnement = "";
            $chaine_contraintes_organisation = "";
            $numero = 9;
            $contraintes = array($contrainte10, $contrainte11, $contrainte12, $contrainte13, $contrainte14, $contrainte15, $contrainte16, $contrainte17, $contrainte18);
            foreach($contraintes as $contrainte) {
                $numero += 1;
                if ($contrainte == true){
                    if(((strlen($chaine_contraintes_environnement))%3 != 0) && (strlen($chaine_contraintes_environnement) > 0)) {
                        $chaine_contraintes_environnement = $chaine_contraintes_environnement.",";
                    }
                    $chaine_contraintes_environnement = $chaine_contraintes_environnement.$numero;
                }
            }
            $evaluationNFX->setContraintesEnvironnement($chaine_contraintes_environnement);
            
            $numero = 19;
            $contraintes = array($contrainte20, $contrainte21, $contrainte22, $contrainte23);
            foreach($contraintes as $contrainte) {
                $numero += 1;
                if ($contrainte == true){
                    if(((strlen($chaine_contraintes_organisation))%3 != 0) && (strlen($chaine_contraintes_organisation) > 0)) {
                        $chaine_contraintes_organisation = $chaine_contraintes_organisation.",";
                    }
                    $chaine_contraintes_organisation = $chaine_contraintes_organisation.$numero;
                }
            }
            $evaluationNFX->setContraintesOrganisation($chaine_contraintes_organisation);

            $manager->persist($evaluationNFX);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_handling_with_assistance_resume', ['id' => $id]);
        }

        return $this->render('NFX35109/handlingWithAssistanceNewConstraints.html.twig', array(
            'form' => $form->createView(),
            'listeContraintesEnvironnement' => $listeContraintesEnvironnement,
            'listeContraintesOrganisation' => $listeContraintesOrganisation,
            'idEvaluation' => $id
        ));
    }

    public function handlingWithAssistanceResume(Request $request, EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $evaluation->getEvaluationNFX();

        $listeCharges = $this->getDoctrine()->getRepository(ChargeNFX::Class);
 
        $charges = $listeCharges->findBy(array('evaluation_nfx' => $evaluationNFX->getId()),
                                                     null,
                                                     null,
                                                     null);

        /* Calcul des coefficients de correction et de la masse corrigée pour chacune des charges */
        foreach($charges as $charge) {
            /* Initialisation des valeurs par défaut et de la valeur de référence */
            $coef_correction1 = 1;
            $coef_correction2 = 1;
            $intitule_coef_correction1 = "";
            $intitule_coef_correction2 = "";

            /* Distance de déplacement */
            if($charge->getDistanceTransportCharge() < 10) {
                /* Conditions acceptables distance inférieure à 10 mètres */
            } elseif (( 10 <= $charge->getDistanceTransportCharge()) && ($charge->getDistanceTransportCharge() < 30)) {
                /* Entre 10 et 30 mètres */
                $coef_correction2 = 0.8;
                $intitule_coef_correction2 = "Distance de déplacement";
            } elseif (( 30 <= $charge->getDistanceTransportCharge()) && ($charge->getDistanceTransportCharge() < 60)) {
                /* Entre 30 et 60 mètres */
                $coef_correction2 = 0.6;
                $intitule_coef_correction2 = "Distance de déplacement";
            } else {
                /* Supérieure à 60 mètres */
                $coef_correction2 = 0.2;
                $intitule_coef_correction2 = "Distance de déplacement";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Conditions d'éxecution de la tâche */
            $nb_contraintes_execution = $charge->getContraintesExecution();
            if(strlen(trim($nb_contraintes_execution)) == 0) {
                /* Aucun facteur défavorable */
            } elseif ((strlen(trim($nb_contraintes_execution) == 1)) && ($coef_correction2 > 0.8)) {
                /* Un facteur défavorable */
                $coef_correction2 = 0.8;
                $intitule_coef_correction2 = "Contraintes d'exécution";
            } elseif ((strlen(trim($nb_contraintes_execution)) > 1) && ($coef_correction2 > 0.7)) {
                /* Plusieurs facteurs défavorables */
                $coef_correction2 = 0.7;
                $intitule_coef_correction2 = "Contraintes d'exécution";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Conditions d'environnement de la tâche */
            $nb_contraintes_environnement = $evaluationNFX->getContraintesEnvironnement();
            if(strlen(trim($nb_contraintes_environnement)) == 0) {
                /* Aucun facteur défavorable */
            } elseif ((strlen(trim($nb_contraintes_environnement)) == 2) && ($coef_correction2 > 0.8)) {
                /* Un facteur défavorable */
                $coef_correction2 = 0.8;
                $intitule_coef_correction2 = "Contraintes d'environnement";
            } elseif ((strlen(trim($nb_contraintes_environnement)) > 2) && ($coef_correction2 > 0.7)) {
                /* Plusieurs facteurs défavorables */
                $coef_correction2 = 0.7;
                $intitule_coef_correction2 = "Contraintes d'environnement";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Conditions d'organisation de la tâche */
            $nb_contraintes_organisation = $evaluationNFX->getContraintesOrganisation();
            if(strlen(trim($nb_contraintes_organisation)) == 0) {
                /* Aucun facteur défavorable */
            } elseif ((strlen(trim($nb_contraintes_organisation)) >= 1) && ($coef_correction2 > 0.9)) {
                /* Un ou plusieurs facteurs défavorables */
                $coef_correction2 = 0.9;
                $intitule_coef_correction2 = "Contraintes d'organisation";
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            /* Transport de charge (mains) */
            if((trim($charge->getTransportCharge()) == trim("Une main")) && ($coef_correction2 > 0.6)) {
                /* Transport à une main */
                $coef_correction2 = 0.6;
                $intitule_coef_correction2 = "Transport à une main";
            } else {
                /* Transport à deux main */
            }

            /* On s'assure que le coefficient de correction le plus contraignant soit le coeffcient 1 */
            if($coef_correction1 > $coef_correction2) {
                $coef_tempo = $coef_correction2;
                $coef_correction2 = $coef_correction1;
                $coef_correction1 = $coef_tempo;
                $intitule_tempo = $intitule_coef_correction2;
                $intitule_coef_correction2 = $intitule_coef_correction1;
                $intitule_coef_correction1 = $intitule_tempo;
            }

            //$masse_corrigee = $masse_corrigee * $coef_correction1 * $coef_correction2;

            //On calcule d'abord le coefficient de proportionnalité afin d'obtenir les forces initial et de maintien en fonction du type de manutention.
            switch($charge->getPTManutentionType()) {
                case "lit":
                    if($charge->getPoidsCharge() <= 100) {
                        $force_initiale_reference = 22;
                        $force_maintien_reference = 9;
                    } elseif((100 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 150)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 100)/(150-100);
                        $force_initiale_reference = 22 + ($coefficient_proportionnalite*(24-22));
                        $force_maintien_reference = 9 + ($coefficient_proportionnalite*(10-9));
                    } elseif($charge->getPoidsCharge() == 150) {
                        $force_initiale_reference = 24;
                        $force_maintien_reference = 10;
                    } elseif((150 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 200)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 150)/(200-150);
                        $force_initiale_reference = 24 + ($coefficient_proportionnalite*(26-24));
                        $force_maintien_reference = 10 + ($coefficient_proportionnalite*(12-10));
                    } elseif($charge->getPoidsCharge() >= 200) {
                        $force_initiale_reference = 26;
                        $force_maintien_reference = 12;
                    }
                    break;
                case "transpalette":
                    if($charge->getPoidsCharge() <= 300) {
                        $force_initiale_reference = 18;
                        $force_maintien_reference = 7;
                    } elseif((300 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 500)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 300)/(500-300);
                        $force_initiale_reference = 18 + ($coefficient_proportionnalite*(24-18));
                        $force_maintien_reference = 7 + ($coefficient_proportionnalite*(10-7));
                    } elseif($charge->getPoidsCharge() == 500) {
                        $force_initiale_reference = 24;
                        $force_maintien_reference = 10;
                    } elseif((500 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 700)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 500)/(700-500);
                        $force_initiale_reference = 24 + ($coefficient_proportionnalite*(30-24));
                        $force_maintien_reference = 10 + ($coefficient_proportionnalite*(13-10));
                    } elseif($charge->getPoidsCharge() == 700) {
                        $force_initiale_reference = 30;
                        $force_maintien_reference = 13;
                    } elseif((700 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 900)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 700)/(900-700);
                        $force_initiale_reference = 30 + ($coefficient_proportionnalite*(38-30));
                        $force_maintien_reference = 13 + ($coefficient_proportionnalite*(17-13));
                    } elseif($charge->getPoidsCharge() >= 900) {
                        $force_initiale_reference = 38;
                        $force_maintien_reference = 17;
                    }
                    break;
                case "chariot":
                    if($charge->getPoidsCharge() <= 100) {
                        $force_initiale_reference = 11;
                        $force_maintien_reference = 5;
                    } elseif((100 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 200)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 100)/(200-100);
                        $force_initiale_reference = 11 + ($coefficient_proportionnalite*(16-11));
                        $force_maintien_reference = 5 + ($coefficient_proportionnalite*(7-5));
                    } elseif($charge->getPoidsCharge() == 200) {
                        $force_initiale_reference = 16;
                        $force_maintien_reference = 7;
                    } elseif((200 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 300)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 200)/(300-200);
                        $force_initiale_reference = 16 + ($coefficient_proportionnalite*(22-16));
                        $force_maintien_reference = 7 + ($coefficient_proportionnalite*(10-7));
                    } elseif($charge->getPoidsCharge() == 300) {
                        $force_initiale_reference = 22;
                        $force_maintien_reference = 10;
                    } elseif((300 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 550)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 300)/(550-300);
                        $force_initiale_reference = 22 + ($coefficient_proportionnalite*(32-22));
                        $force_maintien_reference = 10 + ($coefficient_proportionnalite*(14-10));
                    } elseif($charge->getPoidsCharge() >= 550) {
                        $force_initiale_reference = 32;
                        $force_maintien_reference = 14;
                    } elseif((550 < $charge->getPoidsCharge()) && ($charge->getPoidsCharge() < 800)) {
                        $coefficient_proportionnalite = ($charge->getPoidsCharge() - 550)/(800-550);
                        $force_initiale_reference = 32 + ($coefficient_proportionnalite*(39-32));
                        $force_maintien_reference = 14 + ($coefficient_proportionnalite*(19-14));
                    } elseif($charge->getPoidsCharge() >= 800) {
                        $force_initiale_reference = 39;
                        $force_maintien_reference = 19;
                    }
                    break;
            }

            switch($charge->getPTFrequence()) {
                case "2/min":
                    $force_initiale = 12 * $coef_correction1 * $coef_correction2;
                    $force_maintien = 6 * $coef_correction1 * $coef_correction2;
                    break;
                case "1/min":
                    $force_initiale = 16 * $coef_correction1 * $coef_correction2;
                    $force_maintien = 8 * $coef_correction1 * $coef_correction2;
                    break;
                case "1/5min":
                    $force_initiale = 19 * $coef_correction1 * $coef_correction2;
                    $force_maintien = 9 * $coef_correction1 * $coef_correction2;
                    break;
                case "1/h":
                    $force_initiale = 21 * $coef_correction1 * $coef_correction2;
                    $force_maintien = 10 * $coef_correction1 * $coef_correction2;
                    break;
            }

            $charge->setCoefficientCorrection1($coef_correction1);
            $charge->setCoefficientCorrection2($coef_correction2);
            $charge->setIntituleCoefficientCorrection1($intitule_coef_correction1);
            $charge->setIntituleCoefficientCorrection2($intitule_coef_correction2);
            $charge->setForceInitiale($force_initiale);
            $charge->setForceMaintien($force_maintien);
            $charge->setForceInitialeReference($force_initiale_reference);
            $charge->setForceMaintienReference($force_maintien_reference);

            $manager->persist($charge);
            $manager->flush();
        }

        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);

        $form = $this->createFormBuilder($evaluation)
            ->add('nom')
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();

            $evaluation->setNom($nom);

            $manager->persist($evaluation);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_handling_with_assistance_resume', ['id' => $id]);
        }
        
        return $this->render('NFX35109/handlingWithAssistanceResume.html.twig', array(
            'idEvaluation' => $id,
            'evaluation' => $evaluation,
            'charges' => $charges,
            'form' => $form->createView()
        ));
    }

    public function handlingWithAssistanceResumeCharge($id, $id2){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $evaluation->getEvaluationNFX();
        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $type = 0;
        if($charge->getPTManutentionType() == "lit"){
            $type = 1;
        } elseif ($charge->getPTManutentionType() == "transpalette"){
            $type = 2;
        } elseif ($charge->getPTManutentionType() == "chariot"){
            $type = 3;
        }
        
        $ContraintesExecution = $charge->getContraintesExecution();
        $ContraintesEnvironnement = $evaluationNFX->getContraintesEnvironnement();
        $ContraintesOrganisation = $evaluationNFX->getContraintesOrganisation();

        /* Stockage du nombre de contraintes d'exécutions, d'environnements et d'organisations */
        if(empty($ContraintesExecution)){
            $nbContraintesExecution = 0;
        } else {
            $nbContraintesExecution = (strlen(trim($ContraintesExecution)) + 1)/2;
        }

        if(empty($ContraintesEnvironnement)){
            $nbContraintesEnvironnement = 0;
        } else {
            $nbContraintesEnvironnement = (strlen(trim($ContraintesEnvironnement)) + 1)/3;
        }

        if(empty($ContraintesOrganisation)){
            $nbContraintesOrganisation = 0;
        } else {
            $nbContraintesOrganisation = (strlen(trim($ContraintesOrganisation)) + 1)/3;
        }

        /* On identifie les contraintes d'exécutions, d'environnements et d'organisations de la tâche */
        /* On commence par les contraintes d'exécutions */
        $contraintes = explode(",", $ContraintesExecution);
        //for($i = 0; $i <= $nbContraintesExecution; $i++) {
        foreach($contraintes as $contrainte) {
            switch($contrainte){
                case 1:
                    $charge->setContraintePoigneesInadaptees(true);
                    break;
                case 2:
                    $charge->setContrainteTorsionTronc(true);
                    break;
                case 3:
                    $charge->setContrainteProfondeurPrise(true);
                    break;
                case 4:
                    $charge->setContrainteHorsZoneAtteinte(true);
                    break;
                case 5:
                    $charge->setContraintePosture(true);
                    break;
                case 6:
                    $charge->setContrainteChargeInstable(true);
                    break;
                case 7:
                    $charge->setContrainteVisibiliteLimitee(true);
                    break;
                case 8:
                    $charge->setContrainteRoulettesInadequates(true);
                    break;
                case 9:
                    $charge->setContrainteAbsenceFrein(true);
                    break;
            }
        }
        /* On poursuit avec les contraintes d'environnements */
        $contraintes = explode(",", $ContraintesEnvironnement);
        //for($i = 0; $i <= $nbContraintesEnvironnement; $i++) {
        foreach($contraintes as $contrainte) {
            switch($contrainte){
                case 10:
                    $evaluationNFX->setContraintesThermiques(true);
                    break;
                case 11:
                    $evaluationNFX->setContraintesAcoustiques(true);
                    break;
                case 12:
                    $evaluationNFX->setContraintesLumineuses(true);
                    break;
                case 13:
                    $evaluationNFX->setContrainteVibrations(true);
                    break;
                case 14:
                    $evaluationNFX->setContraintePoussieres(true);
                    break;
                case 15:
                    $evaluationNFX->setContrainteSolsDegrades(true);
                    break;
                case 16:
                    $evaluationNFX->setContrainteEncombrement(true);
                    break;
                case 17:
                    $evaluationNFX->setContrainteObstacles(true);
                    break;
                case 18:
                    $evaluationNFX->setContrainteEspacesInadequats(true);
                    break;
                case 19:
                    $evaluationNFX->setContrainteEtatChariot(true);
                    break;
            }
        }
        /* On finit avec les contraintes d'organisations */
        $contraintes = explode(",", $ContraintesOrganisation);
        //for($i = 0; $i <= $nbContraintesOrganisation; $i++) {
        foreach($contraintes as $contrainte) {
            switch($contrainte){
                case 20:
                    $evaluationNFX->setContrainteTemps(true);
                    break;
                case 21:
                    $evaluationNFX->setContrainteMargeManoeuvreReduite(true);
                    break;
                case 22:
                    $evaluationNFX->setContrainteMultipliciteTaches(true);
                    break;
                case 23:
                    $evaluationNFX->setContrainteExigencesQualite(true);
                    break;
            }
        }

        return $this->render('NFX35109/handlingWithAssistanceResumeCharge.html.twig', array(
            'idEvaluation' => $id,
            'charge' => $charge,
            'evaluationNFX' => $evaluationNFX,
            'nbContraintesExecution' => $nbContraintesExecution,
            'nbContraintesEnvironnement' => $nbContraintesEnvironnement,
            'nbContraintesOrganisation' => $nbContraintesOrganisation,
            'type' => $type
        ));
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

    public function listerContraintesExecution(Request $request, EntityManagerInterface $manager, $id, $id2) {
        $listeContraintes = $this->getDoctrine()
                   ->getRepository(Contrainte::Class);
        
        $listeContraintesExecution = $listeContraintes->findBy(array('categorie_contrainte' => '1'),
                                                            null,
                                                            null,
                                                            null);
        
        unset($listeContraintesExecution[8]);
        unset($listeContraintesExecution[7]);

        //$charge = new ChargeNFX();

        $charge = $this->getDoctrine()->getManager()->getRepository(ChargeNFX::class)
            ->findOneById($id2);

        $form = $this->createFormBuilder($charge)
            //->setAction($this->generateUrl('tutor_comment',array('id' => $id)))
            //->add('contraintes_execution')
            ->add('contrainte_poignees_inadaptees', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Sans poignées ou inadaptées',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_torsion_tronc', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Torsion du tronc',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_hors_zone_atteinte', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Hors zone d\'atteinte',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_posture', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Une ou plusieurs contraintes concernant la posture du corps',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_charge_instable', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Charge instable',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('contrainte_visibilite_limitee', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                 ),
                 'label' => 'Visibilité limitée',
                 'label_attr' => ['class' => ' row switch2 custom-switch'],
                 'required' => true))
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();

            if ($charge->getPriseProfondeur() > 0.4) {
                $form->add('contrainte_profondeur_prise', ChoiceType::class, array(
                    'choices' => array(
                        'Oui' => true,
                        'Non' => false
                     ),
                     'label' => 'Profondeur de prise > 0,40m',
                     'label_attr' => ['class' => ' row switch2 custom-switch'],
                     'required' => true));
            } else {
                $form->add('contrainte_profondeur_prise', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => false,
                        'Oui' => true
                     ),
                     'label' => 'Profondeur de prise > 0,40m',
                     'label_attr' => ['class' => ' row switch2 custom-switch'],
                     'required' => true));
            }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contrainte1 = $form->get('contrainte_poignees_inadaptees')->getData();
            $contrainte2 = $form->get('contrainte_torsion_tronc')->getData();
            $contrainte3 = $form->get('contrainte_profondeur_prise')->getData();
            $contrainte4 = $form->get('contrainte_hors_zone_atteinte')->getData();
            $contrainte5 = $form->get('contrainte_posture')->getData();
            $contrainte6 = $form->get('contrainte_charge_instable')->getData();
            $contrainte7 = $form->get('contrainte_visibilite_limitee')->getData();

            // Faire une boucle, mettre les contraintes dans une liste et bouclé dessus pour mettre des , où c'est nécessaire.
            $chaine_contraintes = "";
            $numero = 0;
            $contraintes = array($contrainte1, $contrainte2, $contrainte3, $contrainte4, $contrainte5, $contrainte6, $contrainte7);
            foreach($contraintes as $contrainte) {
                $numero += 1;
                if ($contrainte == true){
                    if((strlen($chaine_contraintes))%2 == 1 ) {
                        $chaine_contraintes = $chaine_contraintes.",";
                    }
                    $chaine_contraintes = $chaine_contraintes.$numero;
                }
            }
            
            $charge->setContraintesExecution($chaine_contraintes);

            $manager->persist($charge);
            $manager->flush();

            //return $this->redirectToRoute('adept_NFX35109_handling_without_assistance');
            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('NFX35109/handlingWithoutAssistanceExecutionConstraint.html.twig', array(
            'listeContraintes' => $listeContraintesExecution,
            'idEvaluateur' => $id,
            'idSituation' => $id2,
            'form' => $form->createView()
        ));
    }

    public function listerContraintes(Request $request, EntityManagerInterface $manager, $id) {
        $listeContraintes = $this->getDoctrine()
                   ->getRepository(Contrainte::Class);
        
        $listeContraintesEnvironnement = $listeContraintes->findBy(array('categorie_contrainte' => '2'),
                                                            null,
                                                            null,
                                                            null);
        //On retire la contrainte concernant l'état du chariot
        unset($listeContraintesEnvironnement[9]);
        
        $listeContraintesOrganisation = $listeContraintes->findBy(array('categorie_contrainte' => '3'),
                                                            null,
                                                            null,
                                                            null);
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $evaluationNFX = $evaluation->getEvaluationNFX();

        $form = $this->createFormBuilder($evaluationNFX)
        ->add('contraintes_thermiques', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes thermiques',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contraintes_acoustiques', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes acoustiques',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contraintes_lumineuses', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes lumineuses',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_vibrations', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Vibrations',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_poussieres', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Poussières',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_sols_degrades', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Sols dégradés',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_encombrement', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Encombrement',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_obstacles', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Obstacles',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_espaces_inadequats', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Espaces inadéquats pour manœuvrer',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_temps', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Contraintes de temps',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_marge_manoeuvre_reduite', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Marge de manoeuvre réduite',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_multiplicite_taches', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Multiplicité des tâches',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('contrainte_exigences_qualite', ChoiceType::class, array(
            'choices' => array(
                'Non' => false,
                'Oui' => true
            ),
            'label' => 'Exigences qualité',
            'label_attr' => ['class' => ' row switch2 custom-switch'],
            'required' => true))
        ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contrainte10 = $form->get('contraintes_thermiques')->getData();
            $contrainte11 = $form->get('contraintes_acoustiques')->getData();
            $contrainte12 = $form->get('contraintes_lumineuses')->getData();
            $contrainte13 = $form->get('contrainte_vibrations')->getData();
            $contrainte14 = $form->get('contrainte_poussieres')->getData();
            $contrainte15 = $form->get('contrainte_sols_degrades')->getData();
            $contrainte16 = $form->get('contrainte_encombrement')->getData();
            $contrainte17 = $form->get('contrainte_obstacles')->getData();
            $contrainte18 = $form->get('contrainte_espaces_inadequats')->getData();
            $contrainte20 = $form->get('contrainte_temps')->getData();
            $contrainte21 = $form->get('contrainte_marge_manoeuvre_reduite')->getData();
            $contrainte22 = $form->get('contrainte_multiplicite_taches')->getData();
            $contrainte23 = $form->get('contrainte_exigences_qualite')->getData();

            // Faire une boucle, mettre les contraintes dans une liste et bouclé dessus pour mettre des , où c'est nécessaire.
            $chaine_contraintes_environnement = "";
            $chaine_contraintes_organisation = "";
            $numero = 9;
            $contraintes = array($contrainte10, $contrainte11, $contrainte12, $contrainte13, $contrainte14, $contrainte15, $contrainte16, $contrainte17, $contrainte18);
            foreach($contraintes as $contrainte) {
                $numero += 1;
                if ($contrainte == true){
                    if(((strlen($chaine_contraintes_environnement))%3 != 0) && (strlen($chaine_contraintes_environnement) > 0)) {
                        $chaine_contraintes_environnement = $chaine_contraintes_environnement.",";
                    }
                    $chaine_contraintes_environnement = $chaine_contraintes_environnement.$numero;
                }
            }
            $evaluationNFX->setContraintesEnvironnement($chaine_contraintes_environnement);
            
            $numero = 19;
            $contraintes = array($contrainte20, $contrainte21, $contrainte22, $contrainte23);
            foreach($contraintes as $contrainte) {
                $numero += 1;
                if ($contrainte == true){
                    if(((strlen($chaine_contraintes_organisation))%3 != 0) && (strlen($chaine_contraintes_organisation) > 0)) {
                        $chaine_contraintes_organisation = $chaine_contraintes_organisation.",";
                    }
                    $chaine_contraintes_organisation = $chaine_contraintes_organisation.$numero;
                }
            }
            $evaluationNFX->setContraintesOrganisation($chaine_contraintes_organisation);

            $manager->persist($evaluationNFX);
            $manager->flush();

            //return $this->redirectToRoute('adept_NFX35109_handling_without_assistance');
            return $this->redirectToRoute('adept_NFX35109_handling_without_assistance_resume', ['id' => $id]);
        }

        return $this->render('NFX35109/handlingWithoutAssistanceNewConstraints.html.twig', array(
            'form' => $form->createView(),
            'listeContraintesEnvironnement' => $listeContraintesEnvironnement,
            'listeContraintesOrganisation' => $listeContraintesOrganisation,
            'idEvaluation' => $id
        ));
    }

    public function nouvelEvaluateur(Request $request, EntityManagerInterface $manager, UserInterface $user, $id) {
        /*$evaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findOneById($id);*/

        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);

        $evaluateur = $evaluation->getEvaluateur();
        if($evaluation->getEvaluationED6161() != null){
            $evaluation->setSituationNom($evaluation->getSituation()->getNom());
        }
        
        $form = $this->createForm(EvaluationType::class, $evaluation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entreprise = $evaluation->getEntreprise();
            $site = $evaluation->getSite();
            $secteur = $evaluation->getSecteur();
            $posteDeTravail = $evaluation->getPosteDeTravail();
            $situation = $evaluation->getSituation();
            $evaluation->setEvaluateur($evaluateur);

            $entreprise->setEvaluateur($evaluateur);
            $manager->persist($entreprise);

            $site->setEntreprise($entreprise);
            $manager->persist($site);

            $secteur->setSite($site);
            $manager->persist($secteur);

            $posteDeTravail->setSecteur($secteur);
            $manager->persist($posteDeTravail);

            $operateur = new Operateur();
            if($evaluation->getEvaluationED6161() != null){
                $situation = $evaluation->getSituation();
            } else {
                $situation = new Situation();
            }
            
            $situation->setNom($form->get('situation_nom')->getData());
            $situation->setOperateur($operateur);
            //$situation->setPosteDeTravail($posteDeTravail);
            $manager->persist($situation);
            $manager->flush();

            $evaluationNFX = new EvaluationNFX();

            $date = new \DateTime();

            $evaluationNFX->setDateEvaluation($date);
            $manager->persist($evaluationNFX);
            $manager->flush();

            $evaluation->setDateEvaluation($date);

            $evaluation->setEvaluateur($evaluateur);
            $evaluation->setTypeEvaluation('NF X35-109');
            $evaluation->setEvaluationNFX($evaluationNFX);
            $evaluation->setNom($evaluateur->getNom().'_'.$date->format('d/m/Y'));
            $evaluation->setEntreprise($entreprise);
            $evaluation->setSite($site);
            $evaluation->setSecteur($secteur);
            $evaluation->setPosteDeTravail($posteDeTravail);
            $evaluation->setSituation($situation);
            $manager->persist($evaluation);

            /* Modifier nom de la situation correspondant à l'évaluation NF X35 en cours */
            $manager->flush();
            
            return $this->redirectToRoute('adept_NFX35109_picture', ['id' => $evaluation->getId()]);
        }

        return $this->render('NFX35109/activity.html.twig', array(
            'evaluateur' => $evaluateur,
            'form' => $form->createView()
        ));
    }

    public function nouvelEvaluateur2(Request $request, EntityManagerInterface $manager, UserInterface $user, $id, $id2) {
        $evaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findOneById($id);
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id2);

        $situation = $evaluation->getSituation();
        $posteDeTravail = $situation->getPosteDeTravail();
        $secteur = $posteDeTravail->getSecteur();
        $site = $secteur->getSite();
        $entreprise = $site->getEntreprise();
        
        $formEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        $formSite = $this->createForm(SiteType::class, $site);
        $formSecteur = $this->createForm(SecteurType::class, $secteur);
        $formPosteDeTravail = $this->createForm(PosteDeTravailType::class, $posteDeTravail);
        //$formSituation = $this->createForm(SituationType::class, $situation);
        $formSituation = $this->createFormBuilder($situation)
            ->add('nom')
            ->getForm();

        $formEntreprise->handleRequest($request);
        $formSite->handleRequest($request);
        $formSecteur->handleRequest($request);
        $formPosteDeTravail->handleRequest($request);
        $formSituation->handleRequest($request);

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

            $situation->setPosteDeTravail($posteDeTravail);
            $manager->persist($situation);
            $manager->flush();

            $evaluation = new Evaluation();
            $evaluationNFX = new EvaluationNFX();

            $date = new \DateTime();

            $evaluationNFX->setDateEvaluation($date);
            $manager->persist($evaluationNFX);
            $manager->flush();

            $evaluation->setDateEvaluation($date);

            $evaluation->setEvaluateur($evaluateur);
            $evaluation->setSituation($situation);
            $evaluation->setTypeEvaluation('NF X35-109');
            $evaluation->setEvaluationNFX($evaluationNFX);
            $evaluation->setNom($evaluateur->getNom().'_'.$date->format('d/m/Y'));
            $manager->persist($evaluation);
            $manager->flush();
            
            return $this->redirectToRoute('adept_NFX35109_picture', ['id' => $evaluation->getId()]);
        }

        return $this->render('NFX35109/activity.html.twig', array(
            'evaluateur' => $evaluateur,
            'formEntreprise' => $formEntreprise->createView(),
            'formSite' => $formSite->createView(),
            'formSecteur' => $formSecteur->createView(),
            'formPosteDeTravail' => $formPosteDeTravail->createView(),
            'formSituation' => $formSituation->createView(),
        ));
    }

    public function nouvelOperateur(Request $request, EntityManagerInterface $manager, $id) {
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        $situation = $evaluation->getSituation();
        $operateur = $situation->getOperateur();

        $form = $this->createForm(OperateurType::class, $operateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $operateur->setFlagEnceinte(false);
            $manager->persist($operateur);
            $manager->flush();

            return $this->redirectToRoute('adept_NFX35109_activity_detail', ['id' => $id]);
            //return $this->redirectToRoute('adept_NFX35109_operator', ['id' => $id, 'id2' => $id2]);
        }
        return $this->render('NFX35109/operator.html.twig', array(
            'form' => $form->createView(),
            'idEvaluation' => $id
            /*'idEvaluateur' => $id,
            'idSituation' => $id2*/
        ));
    }

    public function picture(Request $request, EntityManagerInterface $manager, $id){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        
        $idEvaluateur = $evaluation->getEvaluateur()->getId();

        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $fichier->getNomFichier();

            if($file->guessExtension() == 'mp4') {
                $nomFichier = "video_";
                $fileType = "video";
            } elseif($file->guessExtension() == 'png' || $file->guessExtension() == 'jpg' || $file->guessExtension() == 'jpeg') {
                $nomFichier = "photo_";
                $fileType = "photo";
            } else {
                $nomFichier = "fichier_";
                $fileType = "fichier";
            }

            $fileName = $nomFichier.'.'.$file->guessExtension();

            //$fileName = "photo_".'.'.$file->guessExtension();
            
            $date = date('Y-m-d H:i:s');

            $file->move($this->getParameter('upload_directory'), $fileName);

            $fichier->setNomFichier($fileName);
            $fichier->setTypeFichier($fileType);
            $fichier->setDateFichier($date);
            //$fichier->setSituation($evaluation);

            $manager->persist($fichier);
            $manager->flush();

            $id2 = $fichier->getId();

            return $this->redirectToRoute('adept_NFX35109_picture_added', ['id' => $id, 'id2' => $id2]);
            //return $this->redirectToRoute('adept_NFX35109_picture', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('NFX35109/picture.html.twig', array(
            'form' => $form->createView(),
            'idEvaluation' => $id,
            'idEvaluateur' => $idEvaluateur/*,
            'id2' => $id2*/
        ));
    }

    public function picture2 (Request $request, EntityManagerInterface $manager, $id, $id2){
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);

        $fichier2 = $this->getDoctrine()->getManager()->getRepository(Fichier::class)
            ->findOneById($id2);

        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $fichier->getNomFichier();

            if($file->guessExtension() == 'mp4') {
                $nomFichier = "video_";
                $fileType = "video";
            } elseif($file->guessExtension() == 'png') {
                $nomFichier = "photo_";
                $fileType = "photo";
            } else {
                $nomFichier = "fichier_";
                $fileType = "fichier";
            }

            $fileName = $nomFichier.'.'.$file->guessExtension();

            //$fileName = "photo_".'.'.$file->guessExtension();
            
            $date = date('Y-m-d H:i:s');

            $file->move($this->getParameter('upload_directory'), $fileName);

            $fichier->setNomFichier($fileName);
            $fichier->setTypeFichier($fileType);
            $fichier->setDateFichier($date);

            $manager->persist($fichier);
            $manager->flush();

            $id2 = $fichier->getId();

            return $this->redirectToRoute('adept_NFX35109_picture', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('NFX35109/picture2.html.twig', array(
            'form' => $form->createView(),
            'fichier' => $fichier2,
            'id' => $id
        ));
    }

    public function seePicture (Request $request, EntityManagerInterface $manager, $id){
        $fichier = $this->getDoctrine ()->getRepository (Fichier::class)->find($id);

        $fileName = $fichier->getNomFichier();
        $file_with_path = $this->getParameter('upload_directory')."/".$fileName;
        $response = new BinaryFileResponse($file_with_path);
        return $response;
        
        /*return $this->render('NFX35109/seePicture.html.twig', array(
            'fichier' => $fichier
        ));*/
    }
}