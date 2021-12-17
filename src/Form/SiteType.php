<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
        ;
    }

    /*public function findAllSitesByCompany(Entreprise $entreprise): array
    {
        $qb = $this->createQueryBuilder('s')
            ->where('p.entreprise  :entreprise')
            ->setParameter('entreprise', $entreprise);

        $query = $qb->getQuery();

        return $query->execute();
    }*/

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}