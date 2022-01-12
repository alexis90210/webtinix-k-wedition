<?php

namespace App\Form;

use App\Entity\KanbanUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecuperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email',EmailType::class,
                [
                    'label' => false,
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>8]
                ])
            ->add('envoyer', SubmitType::class,[  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanUser::class,
        ]);
    }
}
