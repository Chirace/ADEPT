<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Secteur;
use App\Entity\Operateur;
use App\Entity\Situation;

use App\Entity\Entreprise;
use App\Entity\Evaluateur;
use App\Entity\Evaluation;
use App\Entity\SectionNAF;

use App\Entity\DivisionNAF;
use App\Entity\Utilisateur;

// Include PhpSpreadsheet required namespaces
use App\Entity\EvaluationNFX;
use App\Entity\PosteDeTravail;
use App\Form\RegistrationType;
use App\Entity\EvaluationED6161;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $utilisateur = new Utilisateur();

        $form = $this->createForm(RegistrationType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());

            $utilisateur->setPassword($hash);
            $utilisateur->setRoles(['ROLE_UTILISATEUR']);

            $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function index() {
        return $this->render('security/index.html.twig');
    }

    public function administration(){
        return $this->render('security/administration.html.twig');
    }

    public function downloadXLSFiles(Request $request, EntityManagerInterface $manager){
        $spreadsheet = new Spreadsheet();

        //Création de la première page.
        //Entête.
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Entreprise");
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Secteur d\'activité');
        $sheet->setCellValue('D1', 'Effectif');

        $entreprises = $this->getDoctrine()->getManager()->getRepository(Entreprise::class)
            ->findAll();
        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($entreprises as $entreprise) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $entreprise->getId());

            //Nom
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $entreprise->getNom());

            //Secteur d'activité
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $entreprise->getSecteurActivite()->getId());

            //Effectif
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $entreprise->getEffectif());
        }

        //$sheet->setCellValue($cellule, 'Hello World !');

        //Création de la page référentiel des secteurs d'activité.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Secteur activité');
        $spreadsheet->addSheet($sheet, 1);
        $spreadsheet->setActiveSheetIndex(1);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Code NAF');
        $sheet->setCellValue('C1', 'Section NAF');
        $sheet->setCellValue('D1', 'Division NAF');

        $sectionsNAF = $this->getDoctrine()->getManager()->getRepository(SectionNAF::class)
            ->findAll();
        $divisionsNAF = $this->getDoctrine()->getManager()->getRepository(DivisionNAF::class)
            ->findAll();
        
        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($divisionsNAF as $divisionNAF) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $divisionNAF->getId());

            //Code NAF
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $divisionNAF->getSectionNAF()->getCode().$divisionNAF->getCode());

            //Section NAF
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $divisionNAF->getSectionNAF()->getLibelle());

            //Division NAF
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $divisionNAF->getLibelle());
        }

        //Création de la page référentiel des sites.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Site,Établissement');
        $spreadsheet->addSheet($sheet, 2);
        $spreadsheet->setActiveSheetIndex(2);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Identifiant entreprise');

        $sites = $this->getDoctrine()->getManager()->getRepository(Site::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($sites as $site) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $site->getId());

            //Nom
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $site->getNom());

            //Identifiant entreprise
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $site->getEntreprise()->getId());

            //Recherche dans partie Entreprise la cellule de l'entreprise concernée.
            /*$spreadsheet->setActiveSheetIndexByName('Entreprise');
            //$celluleCible = 
            $sheet->setCellValue($cellule, '=Entreprise!A2'/*.$celluleCible*);*/
        }

        //Création de la page référentiel des secteurs.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Secteur');
        $spreadsheet->addSheet($sheet, 3);
        $spreadsheet->setActiveSheetIndex(3);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Identifiant site');

        $secteurs = $this->getDoctrine()->getManager()->getRepository(Secteur::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($secteurs as $secteur) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $secteur->getId());

            //Nom
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $secteur->getNom());

            //Identifiant site
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $secteur->getSite()->getId());
        }

        //Création de la page référentiel des postes de travail.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Poste De Travail');
        $spreadsheet->addSheet($sheet, 4);
        $spreadsheet->setActiveSheetIndex(4);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Identifiant secteur');

        $postesDeTravail = $this->getDoctrine()->getManager()->getRepository(PosteDeTravail::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($postesDeTravail as $posteDeTravail) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $posteDeTravail->getId());

            //Nom
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $posteDeTravail->getNom());

            //Identifiant secteur
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $posteDeTravail->getSecteur()->getId());
        }

        //Création de la page référentiel des situations de travail.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Situation');
        $spreadsheet->addSheet($sheet, 5);
        $spreadsheet->setActiveSheetIndex(5);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Quoi');
        $sheet->setCellValue('D1', 'Comment');
        $sheet->setCellValue('E1', 'Avec qui');
        $sheet->setCellValue('F1', 'Avec quoi');
        $sheet->setCellValue('G1', 'Autre');
        $sheet->setCellValue('H1', 'Identifiant poste de travail');
        $sheet->setCellValue('I1', 'Dimension temporelle');
        $sheet->setCellValue('J1', 'Identifiant Opérateur');

        $situations = $this->getDoctrine()->getManager()->getRepository(Situation::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($situations as $situation) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getId());

            //Nom
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getNom());

            //Quoi
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getQuoi());

            //Comment
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getComment());

            //Avec qui
            $colonne = 'E';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getAvecQui());

            //Avec quoi
            $colonne = 'F';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getAvecQuoi());

            //Autre
            $colonne = 'G';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getAutre());

            //Identifiant poste de travail
            $colonne = 'H';
            $cellule = $colonne.$ligne;
            if($situation->getPosteDeTravail() == null){
                $sheet->setCellValue($cellule, 'null');
            } else {
                $sheet->setCellValue($cellule, $situation->getPosteDeTravail()->getId());
            }
            
            //Dimentsion temporelle
            $colonne = 'I';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getDimensionTemporelle());

            //Identifiant opérateur
            $colonne = 'J';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $situation->getOperateur()->getId());
        }

        //Création de la page référentiel des opérateurs.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Opérateur');
        $spreadsheet->addSheet($sheet, 6);
        $spreadsheet->setActiveSheetIndex(6);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Age');
        $sheet->setCellValue('C1', 'Sexe');
        $sheet->setCellValue('D1', 'flag_enceinte');
        $sheet->setCellValue('E1', 'Formation');
        $sheet->setCellValue('F1', 'Anciennete poste');
        $sheet->setCellValue('G1', 'Anciennete entreprise');
        $sheet->setCellValue('H1', 'Description');
        $sheet->setCellValue('I1', 'Latéralité');

        $operateurs = $this->getDoctrine()->getManager()->getRepository(Operateur::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($operateurs as $operateur) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getId());

            //Age
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getAge());

            //Sexe
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getSexe());

            //Flag enceinte
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getFlagEnceinte());

            //Formation
            $colonne = 'E';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getFormation());

            //Anciennete poste
            $colonne = 'F';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getAnciennetePoste());

            //Anciennete entreprise
            $colonne = 'G';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getAncienneteEntreprise());

            //Description
            $colonne = 'H';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getDescription());

            //Latéralité
            $colonne = 'I';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $operateur->getLateralite());
        }

        //Création de la page référentiel des évaluations.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Évaluation');
        $spreadsheet->addSheet($sheet, 7);
        $spreadsheet->setActiveSheetIndex(7);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Identifiant évaluateur');
        $sheet->setCellValue('C1', 'Type évaluation');
        $sheet->setCellValue('D1', 'Date évaluation');
        $sheet->setCellValue('E1', 'Identifiant situation');
        $sheet->setCellValue('F1', 'Identifiant evaluation NFX');
        $sheet->setCellValue('G1', 'Identifiant poste de travail');
        $sheet->setCellValue('H1', 'Identifiant secteur');
        $sheet->setCellValue('I1', 'Identifiant site');
        $sheet->setCellValue('J1', 'Identifiant entreprise');
        $sheet->setCellValue('K1', 'Identifiant evaluation ED6161');
        $sheet->setCellValue('L1', 'Nom');
        $sheet->setCellValue('M1', 'Flag evaluation interne');

        $evaluations = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($evaluations as $evaluation) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getId());

            //Évaluateur
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getEvaluateur()->getId());

            //Type evaluation
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getTypeEvaluation());

            //Date evaluation
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getDateEvaluation());

            //Identifiant situation
            $colonne = 'E';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getSituation());

            //Identifiant evaluation NFX
            $colonne = 'F';
            $cellule = $colonne.$ligne;
            if($evaluation->getEvaluationNfx() == null){
                $sheet->setCellValue($cellule, 'null');
            } else {
                $sheet->setCellValue($cellule, $evaluation->getEvaluationNfx()->getId());
            }

            //Identifiant poste de travail
            $colonne = 'G';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getPosteDeTravail());

            //Identifiant secteur
            $colonne = 'H';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getSecteur());

            //Identifiant site
            $colonne = 'I';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getSite());

            //Identifiant entreprise
            $colonne = 'J';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getEntreprise());

            //Identifiant evaluation ED6161
            $colonne = 'K';
            $cellule = $colonne.$ligne;
            if($evaluation->getEvaluationED6161() == null){
                $sheet->setCellValue($cellule, 'null');
            } else {
                $sheet->setCellValue($cellule, $evaluation->getEvaluationED6161()->getId());
            }

            //Identifiant Nom
            $colonne = 'L';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getNom());

            //Identifiant flag evaluation interne
            $colonne = 'M';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluation->getEvaluationInterne());
        }

        //Création de la page référentiel des évaluateurs.
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Évaluateur');
        $spreadsheet->addSheet($sheet, 8);
        $spreadsheet->setActiveSheetIndex(8);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Identifiant utilisateur');
        $sheet->setCellValue('C1', 'Identifiant entreprise');
        $sheet->setCellValue('D1', 'Nom');
        $sheet->setCellValue('E1', 'Prénom');
        $sheet->setCellValue('F1', 'Fonction');
        $sheet->setCellValue('G1', 'Identifiant site');

        $evaluateurs = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($evaluateurs as $evaluateur) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluateur->getId());
        
            //Identifiant utilisateur
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluateur->getUtilisateur()->getId());
        
            //Identifiant entreprise
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluateur->getEntreprise()->getId());
        
            //Nom
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluateur->getNom());
        
            //Prénom
            $colonne = 'E';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluateur->getPrenom());
        
            //Fonction
            $colonne = 'F';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluateur->getFonction());
        
            //Identifiant site
            $colonne = 'G';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluateur->getSite()->getId());
        }

        //Création de la page référentiel des évaluations ED6161
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Évaluations ED6161');
        $spreadsheet->addSheet($sheet, 9);
        $spreadsheet->setActiveSheetIndex(9);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Identifiant evaluation');
        $sheet->setCellValue('C1', 'Identifiant secteur');
        $sheet->setCellValue('D1', 'Identifiant poste de travail');
        $sheet->setCellValue('E1', 'Q1_non');
        $sheet->setCellValue('F1', 'Q1_oui');
        $sheet->setCellValue('G1', 'Q2_non');
        $sheet->setCellValue('H1', 'Q2_oui_non_critique');
        $sheet->setCellValue('I1', 'Q2_oui_critique');
        $sheet->setCellValue('J1', 'reperage_q');

        $evaluationsED6161 = $this->getDoctrine()->getManager()->getRepository(EvaluationED6161::class)
            ->findAll();
        
        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($evaluationsED6161 as $evaluationED6161) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getId());
        
            //Identifiant evaluation
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getEvaluation()->getId());
        
            //Identifiant secteur
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getSecteur()->getId());
        
            //Identifiant poste de travail
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getPosteDeTravail()->getId());
        
            //Q1_non
            $colonne = 'E';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getQ1Non());
        
            //Q1_oui
            $colonne = 'F';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getQ1Oui());
        
            //Q2_non
            $colonne = 'G';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getQ2Non());

            //Q2_oui_non_critique
            $colonne = 'H';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getQ2OuiNonCritique());

            //Q2_oui_critique
            $colonne = 'I';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getQ2OuiCritique());

            //Repérage question
            $colonne = 'J';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationED6161->getReperageQ());
        }

        //Création de la page référentiel des évaluations NF X35-109
        $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Évaluations NFX');
        $spreadsheet->addSheet($sheet, 10);
        $spreadsheet->setActiveSheetIndex(10);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Numéro');
        $sheet->setCellValue('B1', 'Date evaluation');
        $sheet->setCellValue('C1', 'Type manutention');
        $sheet->setCellValue('D1', 'Temps tonnage');
        $sheet->setCellValue('E1', 'Tonnage');
        $sheet->setCellValue('F1', 'Frequence charge');
        $sheet->setCellValue('G1', 'Contrainte environnement');
        $sheet->setCellValue('H1', 'Contrainte organisation');

        $evaluationsNFX = $this->getDoctrine()->getManager()->getRepository(EvaluationNFX::class)
            ->findAll();

        //Données.
        $colonne = 'A';
        $ligne = 1;
        $cellule = $colonne.$ligne;
        foreach($evaluationsNFX as $evaluationNFX) {
            //Numéro
            $colonne = 'A';
            $ligne = $ligne + 1;
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getId());
        
            //Date evaluation
            $colonne = 'B';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getDateEvaluation());
        
            //Type manutention
            $colonne = 'C';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getTypeManutention());
        
            //Temps tonnage
            $colonne = 'D';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getTempsTonnage());
        
            //Tonnage
            $colonne = 'E';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getTonnage());
        
            //Frequence charge
            $colonne = 'F';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getFrequenceCharge());
        
            //Contrainte environnement
            $colonne = 'G';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getContraintesEnvironnement());

            //Contrainte organisation
            $colonne = 'H';
            $cellule = $colonne.$ligne;
            $sheet->setCellValue($cellule, $evaluationNFX->getContraintesOrganisation());
        }

        $writer = new Xlsx($spreadsheet);

        $fileName = 'Données_ADEPT.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        $writer->save($temp_file);

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login() {
        return $this->render('general/home.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}
}
