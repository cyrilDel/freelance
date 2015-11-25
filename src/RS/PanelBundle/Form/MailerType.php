<?php

namespace RS\PanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MailerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('courriel',    'text')
            ->add('objet',       'text')
            ->add('message', 'textarea')
            ->add('Envoyer', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RS\PanelBundle\Entity\Mailer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_panelbundle_mailer';
    }
}
