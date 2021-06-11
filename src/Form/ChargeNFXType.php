<?php

namespace App\Form;

use App\Entity\ChargeNFX;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChargeNFXType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poids_charge')
            ->add('prise_hauteur')
            ->add('prise_profondeur')
            ->add('transport_charge', ChoiceType::class, array(
                'choices'  => array(
                    'Une main' => 'Une main', 
                    'Deux mains' => 'Deux mains'
                ),
            ))
            ->add('distance_transport_charge')
            ->add('depose_hauteur')
            ->add('depose_profondeur')
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChargeNFX::class,
        ]);
    }
}