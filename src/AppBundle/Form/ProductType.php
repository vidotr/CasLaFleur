<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('designation', TextType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez un nom'), 'label' => null))
                ->add('price', NumberType::class, array('attr'=> array('class' => 'form-control', 'placeholder' => 'Entrez le prix'), 'label' => null))
                ->add('picture', FileType::class, array('attr'=> array('class' => 'form-control-file'), 'label' => null))
                ->add('save', SubmitType::class, array('attr'=> array('class' => 'btn btn-primary float-right'), 'label' => 'Ajouter'))
                ->getForm();
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }


}
