<?php

namespace App\Form;

use App\Entity\KanbanUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReinitialisationCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('PlainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password' , 'mapped' => false),
                'second_options' => array('label' => 'Confirmez le Password' , 'mapped' => false),
                'mapped' => false,
                'attr' => [
                    'class' => 'px-4 py-2 transition duration-300 border border-gray-300 bg-transparent rounded focus:border-transparent focus:outline-none focus:ring-4 focus:ring-blue-200',
                    'placeholder' => 'Entrez votre mot de passe',
                    'maxlength'=>30, 'minlength'=>5
                ]
            ))
            ->add('MODIFIER', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary mt-5',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanUser::class,
        ]);
    }
}
