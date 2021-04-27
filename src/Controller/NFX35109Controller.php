<?php 
namespace App\Controller; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Fichier;
use App\Form\FichierType;

class NFX35109Controller extends AbstractController {

    public function NFX35109(){
        return $this->render('NFX35109/home.html.twig');
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