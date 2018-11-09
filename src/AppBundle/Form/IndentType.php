<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IndentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez votre prenom'), 'label' => null))
                ->add('lastname', TextType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez votre nom'), 'label' => null))
                ->add('numberDelivery', TextType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez votre numéro de rue'), 'label' => null))
                ->add('streetDelivery', TextareaType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez votre rue'), 'label' => null))
                ->add('zipCode', TextType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez votre code postal'), 'label' => null))
                ->add('townDelivery', TextType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez votre ville'), 'label' => null))
                ->add('save', SubmitType::class, array('attr'=> array('class' => 'btn btn-primary float-right'), 'label' => 'Valider la commande'))
                ->getForm();
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Indent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_indent';
    }


}
