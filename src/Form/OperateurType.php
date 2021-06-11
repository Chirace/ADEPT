<?php

namespace App\Form;

use App\Entity\Operateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OperateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('age')
            /*->add('sexe', ChoiceType::class, array(
                'choices'  => array(
                    'Masculin' => 'Masculin', 
                    'Feminin' => 'Feminin'
                ),
            ))*/
            /*->add('Flag_Enceinte', ChoiceType::class, array(
                'choices'  => array(
                    'Oui' => 'Oui', 
                    'Non' => 'Non'
                ),
            ))*/
            ->add('Flag_Droitier', ChoiceType::class, array(
                'choices'  => array(
                    'Droitier' => 'Droitier', 
                    'Gaucher' => 'Gaucher'
                ),
            ))
            ->add('Formation')
            ->add('Anciennete_poste')
            ->add('Anciennete_entreprise')
            ->add('Description', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ]);
            #->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operateur::class,
        ]);
    }
}
