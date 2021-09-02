<?php

namespace App\Form;

use App\Form\SiteType;
use App\Entity\Evaluateur;
use App\Entity\DivisionNAF;
use App\Form\EntrepriseType;
use App\Form\DivisionNAFType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EvaluateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('fonction')
            ->add('entreprise', EntrepriseType::class)
            ->add('site', SiteType::class)
            ->add('entreprise_exterieure', EntrepriseType::class, array('required' => false))
            ->add('site_exterieur', SiteType::class, array('required' => false))
            //->add('secteur_activite', DivisionNAFType::class)
            ->add('secteur_activite', EntityType::class, array(
                'class' => DivisionNAF::class,
                'required' => false,
                'choice_label' => function ($divisionNAF) {
                    return $divisionNAF->getSectionNAF()->getCode() . ' - ' . $divisionNAF->getCode() . ' - ' . $divisionNAF->getLibelle();
                }
            ))
            ->add('effectif')
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evaluateur::class,
        ]);
    }
}