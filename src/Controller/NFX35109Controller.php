<?php 
namespace App\Controller; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Fichier;
use App\Form\FichierType;
use App\Entity\Contrainte;
use App\Form\ContrainteExecutionType;

class NFX35109Controller extends AbstractController {

    public function NFX35109(){
        return $this->render('NFX35109/home.html.twig');
    }
    
    public function activity(){
        return $this->render('NFX35109/activity.html.twig');
    }

    public function operator(){
        return $this->render('NFX35109/operator.html.twig');
    }

    public function activityDetail(){
        return $this->render('NFX35109/activityDetail.html.twig');
    }

    public function handlingType(){
        return $this->render('NFX35109/handlingType.html.twig');
    }

    public function handlingWithoutAssistance(){
        return $this->render('NFX35109/handlingWithoutAssistance.html.twig');
    }

    public function handlingWithoutAssistanceNewCharge(){
        return $this->render('NFX35109/handlingWithoutAssistanceChargeInformations.html.twig');
    }
    
    public function handlingWithoutAssistanceNewChargeConstraint(){
        return $this->render('NFX35109/handlingWithoutAssistanceExecutionConstraint.html.twig');
    }
    
    public function handlingWithoutAssistanceTonnageFrequency(){
        return $this->render('NFX35109/handlingWithoutAssistanceTonnageFrequency.html.twig');
    }
    
    public function handlingWithoutAssistanceNewConstraints(){
        return $this->render('NFX35109/handlingWithoutAssistanceNewConstraints.html.twig');
    }
    
    public function handlingWithoutAssistanceResume(){
        return $this->render('NFX35109/handlingWithoutAssistanceResume.html.twig');
    }
    
    public function handlingWithoutAssistanceResumeCharge(){
        return $this->render('NFX35109/handlingWithoutAssistanceResumeCharge.html.twig');
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

    public function listerContraintesExecution(Request $request) {
        $listeContraintes = $this->getDoctrine()
                   ->getRepository(Contrainte::Class);
        
        $listeContraintesExecution = $listeContraintes->findBy(array('categorie_contrainte' => '1'),
                                                            null,
                                                            null,
                                                            null);

        return $this->render('NFX35109/handlingWithoutAssistanceExecutionConstraint.html.twig', array(
            'listeContraintes' => $listeContraintesExecution
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

    public function picture(Request $request){
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $fichier->getNomFichier();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move($this->getParameter('upload_directory'), $fileName);
            $fichier->setNomFichier($fileName);

            return $this->redirectToRoute('adept_NFX35109_picture');
        }

        return $this->render('NFX35109/picture.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}