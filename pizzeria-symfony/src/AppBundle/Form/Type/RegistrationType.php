<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class)
        ->add('surname', TextType::class)
        ->add('password', PasswordType::class)
        ->add('city', TextType::class)
        ->add('address', TextType::class)
        ->add('postalCode', TextType::class)
        ->add('email', TextType::class)
        ->add('phone', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Submit',
            'attr'   =>  array(
                'class'   => 'btn btn-primary')))
        ;
    }
}