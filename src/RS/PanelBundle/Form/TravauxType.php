<?php

namespace RS\PanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TravauxType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', 'text', array('required' => false))
            ->add('tarifheure', 'integer', array('required' => false))
            ->add('tarifjournee', 'integer', array('required' => false))
            ->add('nombresheures', 'number', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RS\PanelBundle\Entity\Travaux'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_panelbundle_travaux';
    }
}
