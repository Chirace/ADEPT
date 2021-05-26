<?php

namespace App\Form;

use App\Entity\Contrainte;
use Doctrine\ORM\EntityRepository;
use App\Entity\CategorieContrainte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContrainteExecutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('intitule')
            ->add('categorie_contrainte', EntityType::class,  array('class' => CategorieContrainte::class,
            'query_builder' => function (EntityRepository $repo) {
                return $repo->createQueryBuilder('c')
                ->where('c.id = 1'); }
            ));*/
            ->add('intitule', EntityType::class,  array('class' => Contrainte::class,
            'query_builder' => function (EntityRepository $repo) {
                return $repo->createQueryBuilder('c')
                ->where('c.categorie_contrainte = 1'); }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contrainte::class,
        ]);
    }
}