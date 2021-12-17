<?php

namespace App\Form;

use App\Entity\BilanEntreprise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilanEntrepriseType extends AbstractType
{
    /*private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }*/

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
        ;

        /*$builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));*/
    }

    /*protected function addElements(FormInterface $form, Site $site = null) {
        $form->add('site', EntityType::class, array(
            'required' => true,
            'data' => $site,
            'placeholder' => 'Choisir un site...',
            'class' =>  Site::class,
        ));
        
        $secteurs = array();
        
        if ($site) {
            $repoSecteur = $this->em->getRepository(Secteur::class);
            
            $secteurs = $repoSecteur->createQueryBuilder('s')
                ->where('s.site = :site_id')
                ->setParameter('site_id', $site->getId())
                ->getQuery()
                ->getResult();
        }
        
        $form->add('secteur', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Choisir d\'abord un site ...',
            'class' => Secteur::class,
            'choices' => $secteur
        ));
    }
    
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        
        $site = $this->em->getRepository(Site::class)->find($data['site']);
        
        $this->addElements($form, $site);
    }

    function onPreSetData(FormEvent $event) {
        $bilan = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $site = $person->getCity() ? $person->getCity() : null;
        
        $this->addElements($form, $city);
    }*/

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BilanEntreprise::class,
        ]);
    }
}