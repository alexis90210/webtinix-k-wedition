<?php

namespace App\Form;

use App\Entity\KanbanUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class,
                [
                    'label' => 'Pseudo',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>10, 'minlength'=>4]
                    ])
            ->add('email',EmailType::class,
                [
                    'label' => 'Email',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>5]
                ])
            ->add('password',PasswordType::class,
                [
                    'label' => 'Password',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>4]
                ])

            ->add('ConfirmezPassword',PasswordType::class,
                [
                    'mapped'=>false,
                    'label' => 'Confirmez Password',
                    'required' => true,
                    'constraints' => [],
                ])
           /* ->add('PlainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'mapped'=>false,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Confirmez le Password'),
            ))*/
            ->add('INSCRIPTION', SubmitType::class,[

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
