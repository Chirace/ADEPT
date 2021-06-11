<?php

namespace App\Form;

use App\Entity\Situation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SituationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            #->add('quoi')
            #->add('pourquoi')
            #->add('comment')
            #->add('avec_qui')
            #->add('avec_quoi')
            #->add('organisation_travail')
            #->add('autre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Situation::class,
        ]);
    }
}