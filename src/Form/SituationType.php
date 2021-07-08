<?php

namespace App\Form;

use App\Entity\Situation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SituationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('quoi', TextType::class, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('comment', TextType::class, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('avec_qui', TextType::class, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('avec_quoi', TextType::class, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('dimension_temporelle', TextType::class, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('autre', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
                'empty_data' => '',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Situation::class,
        ]);
    }
}