<?php

namespace App\Form;

use App\Entity\Evaluation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('evaluateur', EvaluateurType::class)
            /*->add('type_evaluation')
            ->add('date_evaluation')*/
            ->add('situation_nom')
            //->add('situation', SituationType::class)
            ->add('posteDeTravail', PosteDeTravailType::class)
            ->add('secteur', SecteurType::class)
            ->add('site', SiteType::class)
            ->add('entreprise', EntrepriseType::class)
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}