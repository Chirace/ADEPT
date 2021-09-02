<?php

namespace App\Controller;

use App\Entity\Secteur;
use App\Form\SecteurType;
use App\Entity\Evaluateur;
use App\Entity\Evaluation;
use App\Entity\DomaineED6161;
use App\Entity\Grille1ED6161;
use App\Entity\Grille2ED6161;
use App\Entity\PosteDeTravail;
use App\Entity\QuestionED6161;
use App\Entity\EvaluationED6161;
use App\Form\PosteDeTravailType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ED6161Controller extends AbstractController
{
    /**
     * @Route("/e/d6161", name="e_d6161")
     */
    public function index(): Response
    {
        return $this->render('ed6161/index.html.twig', [
            'controller_name' => 'ED6161Controller',
        ]);
    }

    public function newED6161(Request $request, EntityManagerInterface $manager, $id) {
        $evaluateur = $this->getDoctrine()->getManager()->getRepository(Evaluateur::class)
            ->findOneById($id);

        $evaluation = new Evaluation();
        $date = new \DateTime();

        $evaluation->setEvaluateur($evaluateur);
        $evaluation->setTypeEvaluation("ED6161");
        $evaluation->setDateEvaluation($date);

        $manager->persist($evaluation);
        $manager->flush();

        $id2 = $evaluation->getId();

        return $this->redirectToRoute('adept_tool_ED6161', ['id' => $id2]);
    }

    public function ED6161(Request $request, EntityManagerInterface $manager, $id) {
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);
        
        $listeMotClefQ1 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 1),
        );

        $listeMotClefQ2 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 2)
        );

        $listeMotClefQ3 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 3)
        );

        $listeMotClefQ4 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId(),
            'reperage_Q' => 4)
        );

        $evaluationED6161 = new EvaluationED6161();

        $form = $this->createFormBuilder($evaluationED6161)
            ->add('secteur1', SecteurType::class, array(
                'required' => false))
            ->add('posteDeTravail1', PosteDeTravailType::class, array(
                'required' => false))
            ->add('secteur2', SecteurType::class, array(
                'required' => false))
            ->add('posteDeTravail2', PosteDeTravailType::class, array(
                'required' => false))
            ->add('secteur3', SecteurType::class, array(
                'required' => false))
            ->add('posteDeTravail3', PosteDeTravailType::class, array(
                'required' => false))
            ->add('secteur4', SecteurType::class, array(
                'required' => false))
            ->add('posteDeTravail4', PosteDeTravailType::class, array(
                'required' => false))
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->add('valider2', SubmitType::class, array('label'=> 'Continuer'))
            ->add('valider3', SubmitType::class, array('label'=> 'Continuer'))
            ->add('valider4', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(($form->get('secteur1')->getData() != null) and ($form->get('posteDeTravail1')->getData() != null)) {
                $secteur = $form->get('secteur1')->getData();
                $posteDeTravail = $form->get('posteDeTravail1')->getData();
                $manager->persist($secteur);
                $manager->persist($posteDeTravail);
                $manager->flush();

                $evaluationED6161->setEvaluation($evaluation);
                $evaluationED6161->setSecteur($secteur);
                $evaluationED6161->setPosteDeTravail($posteDeTravail);
                $evaluationED6161->setReperageQ(1);
            } elseif(($form->get('secteur2')->getData() != null) and ($form->get('posteDeTravail2')->getData() != null)) {
                $secteur = $form->get('secteur2')->getData();
                $posteDeTravail = $form->get('posteDeTravail2')->getData();
                $manager->persist($secteur);
                $manager->persist($posteDeTravail);
                $manager->flush();

                $evaluationED6161->setEvaluation($evaluation);
                $evaluationED6161->setSecteur($secteur);
                $evaluationED6161->setPosteDeTravail($posteDeTravail);
                $evaluationED6161->setReperageQ(2);
            } elseif(($form->get('secteur3')->getData() != null) and ($form->get('posteDeTravail3')->getData() != null)) {
                $secteur = $form->get('secteur3')->getData();
                $posteDeTravail = $form->get('posteDeTravail3')->getData();
                $manager->persist($secteur);
                $manager->persist($posteDeTravail);
                $manager->flush();

                $evaluationED6161->setEvaluation($evaluation);
                $evaluationED6161->setSecteur($secteur);
                $evaluationED6161->setPosteDeTravail($posteDeTravail);
                $evaluationED6161->setReperageQ(3);
            } elseif(($form->get('secteur4')->getData() != null) and ($form->get('posteDeTravail4')->getData() != null)) {
                $secteur = $form->get('secteur4')->getData();
                $posteDeTravail = $form->get('posteDeTravail4')->getData();
                $manager->persist($secteur);
                $manager->persist($posteDeTravail);
                $manager->flush();

                $evaluationED6161->setEvaluation($evaluation);
                $evaluationED6161->setSecteur($secteur);
                $evaluationED6161->setPosteDeTravail($posteDeTravail);
                $evaluationED6161->setReperageQ(4);
            }
            
            $manager->persist($evaluationED6161);
            $manager->flush();
            
            return $this->redirectToRoute('adept_tool_ED6161', ['id' => $id]);
        }
        return $this->render('ed6161/home.html.twig', array(
            'id' => $id,
            'listeMotClefQ1' => $listeMotClefQ1,
            'listeMotClefQ2' => $listeMotClefQ2,
            'listeMotClefQ3' => $listeMotClefQ3,
            'listeMotClefQ4' => $listeMotClefQ4,
            'form' => $form->createView()
        ));
    }

    public function ED6161Resume(Request $request, EntityManagerInterface $manager, $id) {
        $evaluation = $this->getDoctrine()->getManager()->getRepository(Evaluation::class)
            ->findOneById($id);

        $evaluationsED6161 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findBy(
            array('evaluation' => $evaluation->getId())
        );

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

            return $this->redirectToRoute('adept_ED6161_resume', ['id' => $id]);
        }
        return $this->render('ed6161/resume.html.twig', array(
            'id' => $id,
            'evaluations' => $evaluationsED6161,
            'form' => $form->createView()
        ));
    }

    public function ED6161Grille1(Request $request, EntityManagerInterface $manager, $id, $id2) {
        $evaluationED6161 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findOneById($id2);

        $domaine1ED6161 = $this->getDoctrine()->getRepository(DomaineED6161::Class)->findOneById(1);

        $domaine2ED6161 = $this->getDoctrine()->getRepository(DomaineED6161::Class)->findOneById(2);

        $questionsED6161 = $this->getDoctrine()->getRepository(QuestionED6161::Class);

        $questionsGrille1ED6161 = $questionsED6161->findBy(array('domaine_ED6161' => array($domaine1ED6161, $domaine2ED6161)),
                null,
                null,
                null);

        $grille1 = $this->getDoctrine()->getRepository(Grille1ED6161::class)->findOneBy(array('evaluation_ED6161' => $evaluationED6161));

        if($grille1 == null) {
            $grille1 = new Grille1ED6161();
            $valeursDefault = null;
        } else {
            $valeursDefault = explode(",",$grille1->getValeurs(), 7);
        }

        $form = $this->createFormBuilder($grille1)
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();

        if($valeursDefault != null) {
            if($valeursDefault[0] == "0") {
                $form->add('value_Q1', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q1', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "1",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
            if($valeursDefault[1] == "0") {
                $form->add('value_Q2', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q2', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "1",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
            if($valeursDefault[2] == "0") {
                $form->add('value_Q3', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q3', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "1",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
            if($valeursDefault[3] == "0") {
                $form->add('value_Q4', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q4', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "1",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
            if($valeursDefault[4] == "0") {
                $form->add('value_Q5', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q5', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "1",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
            if($valeursDefault[5] == "0") {
                $form->add('value_Q6', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q6', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "1",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
            if($valeursDefault[6] == "0") {
                $form->add('value_Q7', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q7', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'Oui' => "1"
                    ),
                    'data' => "1",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
        } else {
            $form->add('value_Q1', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'Oui' => "1"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q2', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'Oui' => "1"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q3', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'Oui' => "1"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q4', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'Oui' => "1"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q5', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'Oui' => "1"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q6', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'Oui' => "1"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q7', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'Oui' => "1"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $grille1->setEvaluationED6161($evaluationED6161);

            $valueQ1 = $form->get('value_Q1')->getData();
            $valueQ2 = $form->get('value_Q2')->getData();
            $valueQ3 = $form->get('value_Q3')->getData();
            $valueQ4 = $form->get('value_Q4')->getData();
            $valueQ5 = $form->get('value_Q5')->getData();
            $valueQ6 = $form->get('value_Q6')->getData();
            $valueQ7 = $form->get('value_Q7')->getData();

            $valeurs = $valueQ1.','.$valueQ2.','.$valueQ3.','.$valueQ4.','.$valueQ5.','.$valueQ6.','.$valueQ7;
            $NbOui = mb_substr_count($valeurs, "1");
            $NbNon = mb_substr_count($valeurs, "0");

            $grille1->setValeurs($valeurs);
            $evaluationED6161->setQ1Non($NbNon);
            $evaluationED6161->setQ1Oui($NbOui);


            $manager->persist($grille1);
            $manager->persist($evaluationED6161);
            $manager->flush();

            return $this->redirectToRoute('adept_ED6161_grille_2', ['id' => $id, 'id2' => $id2]);
        }

        return $this->render('ed6161/grille1.html.twig', array(
            'id' => $id,
            'id2' => $id2,
            'domaine1ED6161' => $domaine1ED6161,
            'domaine2ED6161' => $domaine2ED6161,
            'questionsGrille1ED6161' => $questionsGrille1ED6161,
            'form' => $form->createView()
        ));
    }

    public function ED6161Grille2(Request $request, EntityManagerInterface $manager, $id, $id2) {
        $evaluationED6161 = $this->getDoctrine()->getRepository(EvaluationED6161::class)->findOneById($id2);

        $domaine3ED6161 = $this->getDoctrine()->getRepository(DomaineED6161::Class)->findOneById(3);
        $domaine4ED6161 = $this->getDoctrine()->getRepository(DomaineED6161::Class)->findOneById(4);
        $domaine5ED6161 = $this->getDoctrine()->getRepository(DomaineED6161::Class)->findOneById(5);
        $domaine6ED6161 = $this->getDoctrine()->getRepository(DomaineED6161::Class)->findOneById(6);
        $domaine7ED6161 = $this->getDoctrine()->getRepository(DomaineED6161::Class)->findOneById(7);
        
        $questionsED6161 = $this->getDoctrine()->getRepository(QuestionED6161::Class);
        $questionsGrille2ED6161 = $questionsED6161->findBy(array('domaine_ED6161' => array(3, 4, 5, 6, 7)),
                null,
                null,
                null);
        
        $grille2 = $this->getDoctrine()->getRepository(Grille2ED6161::class)->findOneBy(array('evaluation_ED6161' => $evaluationED6161));

        if($grille2 == null) {
            $grille2 = new Grille2ED6161();
            $valeursDefault = null;
            
        } else {
            $valeursDefault = explode(",",$grille2->getValeurs(), 25);
        }
        $form = $this->createFormBuilder($grille2)
            ->add('valider', SubmitType::class, array('label'=> 'Continuer'))
            ->getForm();
        
        if($valeursDefault != null) {
            if($valeursDefault[0] == "0") {
                $form->add('value_Q1', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[0] == "2") {
                $form->add('value_Q1', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q1', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[1] == "0") {
                $form->add('value_Q2', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[1] == "2") {
                $form->add('value_Q2', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q2', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[2] == "0") {
                $form->add('value_Q3', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[2] == "2") {
                $form->add('value_Q3', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q3', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[3] == "0") {
                $form->add('value_Q4', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[3] == "2") {
                $form->add('value_Q4', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q4', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[4] == "0") {
                $form->add('value_Q5', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[4] == "2") {
                $form->add('value_Q5', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q5', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[5] == "0") {
                $form->add('value_Q6', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[5] == "2") {
                $form->add('value_Q6', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q6', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[6] == "0") {
                $form->add('value_Q7', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[6] == "2") {
                $form->add('value_Q7', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q7', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[7] == "0") {
                $form->add('value_Q8', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[7] == "2") {
                $form->add('value_Q8', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q8', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[8] == "0") {
                $form->add('value_Q9', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[8] == "2") {
                $form->add('value_Q9', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q9', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[9] == "0") {
                $form->add('value_Q10', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[9] == "2") {
                $form->add('value_Q10', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q10', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[10] == "0") {
                $form->add('value_Q11', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[10] == "2") {
                $form->add('value_Q11', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q11', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[11] == "0") {
                $form->add('value_Q12', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[11] == "2") {
                $form->add('value_Q12', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q12', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[12] == "0") {
                $form->add('value_Q13', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[12] == "2") {
                $form->add('value_Q13', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q13', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[13] == "0") {
                $form->add('value_Q14', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[13] == "2") {
                $form->add('value_Q14', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q14', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[14] == "0") {
                $form->add('value_Q15', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[14] == "2") {
                $form->add('value_Q15', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q15', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[15] == "0") {
                $form->add('value_Q16', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[15] == "2") {
                $form->add('value_Q16', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q16', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[16] == "0") {
                $form->add('value_Q17', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[16] == "2") {
                $form->add('value_Q17', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q17', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[17] == "0") {
                $form->add('value_Q18', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[17] == "2") {
                $form->add('value_Q18', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q18', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[18] == "0") {
                $form->add('value_Q19', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[18] == "2") {
                $form->add('value_Q19', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q19', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[19] == "0") {
                $form->add('value_Q20', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[19] == "2") {
                $form->add('value_Q20', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q20', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[20] == "0") {
                $form->add('value_Q21', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[20] == "2") {
                $form->add('value_Q21', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q21', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[21] == "0") {
                $form->add('value_Q22', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[21] == "2") {
                $form->add('value_Q22', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q22', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[22] == "0") {
                $form->add('value_Q23', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[22] == "2") {
                $form->add('value_Q23', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q23', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[23] == "0") {
                $form->add('value_Q24', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[23] == "2") {
                $form->add('value_Q24', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q24', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }

            if($valeursDefault[24] == "0") {
                $form->add('value_Q25', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "0",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } elseif($valeursDefault[24] == "2") {
                $form->add('value_Q25', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "2",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            } else {
                $form->add('value_Q25', ChoiceType::class, array(
                    'choices' => array(
                        'Non' => "0",
                        'OuiMais' => "2",
                        'Oui' => "3"
                    ),
                    'data' => "3",
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true));
            }
        } else {
            $form->add('value_Q1', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q2', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q3', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q4', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q5', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q6', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q7', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q8', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q9', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q10', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q11', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q12', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q13', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q14', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q15', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q16', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q17', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q18', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q19', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q20', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q21', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q22', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q23', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q24', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
            $form->add('value_Q25', ChoiceType::class, array(
                'choices' => array(
                    'Non' => "0",
                    'OuiMais' => "2",
                    'Oui' => "3"
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => true));
        }
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $grille2->setEvaluationED6161($evaluationED6161);

            $valueQ1 = $form->get('value_Q1')->getData();
            $valueQ2 = $form->get('value_Q2')->getData();
            $valueQ3 = $form->get('value_Q3')->getData();
            $valueQ4 = $form->get('value_Q4')->getData();
            $valueQ5 = $form->get('value_Q5')->getData();
            $valueQ6 = $form->get('value_Q6')->getData();
            $valueQ7 = $form->get('value_Q7')->getData();
            $valueQ8 = $form->get('value_Q8')->getData();
            $valueQ9 = $form->get('value_Q9')->getData();
            $valueQ10 = $form->get('value_Q10')->getData();
            $valueQ11 = $form->get('value_Q11')->getData();
            $valueQ12 = $form->get('value_Q12')->getData();
            $valueQ13 = $form->get('value_Q13')->getData();
            $valueQ14 = $form->get('value_Q14')->getData();
            $valueQ15 = $form->get('value_Q15')->getData();
            $valueQ16 = $form->get('value_Q16')->getData();
            $valueQ17 = $form->get('value_Q17')->getData();
            $valueQ18 = $form->get('value_Q18')->getData();
            $valueQ19 = $form->get('value_Q19')->getData();
            $valueQ20 = $form->get('value_Q20')->getData();
            $valueQ21 = $form->get('value_Q21')->getData();
            $valueQ22 = $form->get('value_Q22')->getData();
            $valueQ23 = $form->get('value_Q23')->getData();
            $valueQ24 = $form->get('value_Q24')->getData();
            $valueQ25 = $form->get('value_Q25')->getData();

            $valeurs = $valueQ1.','.$valueQ2.','.$valueQ3.','.$valueQ4.','.$valueQ5.','.
                    $valueQ6.','.$valueQ7.','.$valueQ8.','.$valueQ9.','.$valueQ10.','.
                    $valueQ11.','.$valueQ12.','.$valueQ13.','.$valueQ14.','.$valueQ15.','.
                    $valueQ16.','.$valueQ17.','.$valueQ18.','.$valueQ19.','.$valueQ20.','.
                    $valueQ21.','.$valueQ22.','.$valueQ23.','.$valueQ24.','.$valueQ25;
            $NbOui = mb_substr_count($valeurs, "3");
            $NbOuiMais = mb_substr_count($valeurs, "2");
            $NbNon = mb_substr_count($valeurs, "0");

            $grille2->setValeurs($valeurs);
            $evaluationED6161->setQ2Non($NbNon);
            $evaluationED6161->setQ2OuiNonCritique($NbOuiMais);
            $evaluationED6161->setQ2OuiCritique($NbOui);

            $manager->persist($grille2);
            $manager->persist($evaluationED6161);
            $manager->flush();

            return $this->redirectToRoute('adept_ED6161_resume', ['id' => $id]);
        }

        return $this->render('ed6161/grille2.html.twig', array(
            'id' => $id,
            'id2' => $id2,
            'domaine3ED6161' => $domaine3ED6161,
            'domaine4ED6161' => $domaine4ED6161,
            'domaine5ED6161' => $domaine5ED6161,
            'domaine6ED6161' => $domaine6ED6161,
            'domaine7ED6161' => $domaine7ED6161,
            'questionsGrille2ED6161' => $questionsGrille2ED6161,
            'form' => $form->createView()
        ));
    }

    public function addSituation(Request $request, EntityManagerInterface $manager, $id) {
        return $this->render('ed6161/home.html.twig', array('idEvaluateur' => $id));
    }
}
