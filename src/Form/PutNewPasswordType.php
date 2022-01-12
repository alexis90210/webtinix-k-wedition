<?php

namespace App\Form;

use App\Entity\KanbanUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PutNewPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email',EmailType::class,
                [
                    'label' => 'Email',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>8]
                ])
            ->add('password',PasswordType::class,
                [
                    'label' => 'new Password',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>4]
                ])
            ->add('REINITIALISER', SubmitType::class,[
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
