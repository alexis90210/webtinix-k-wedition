<?php

namespace App\Form;

use App\Entity\KanbanContactUs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KanbanContactUsType extends AbstractType
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
            ->add('sujet', TextType::class,
                [
                    'label' => 'sujet',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>8]

                ])
            ->add('message', TextareaType::class,
                [
                    'label' => 'message',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>255, 'minlength'=>30]

                ])
            ->add('ENVOYEZ', SubmitType::class,[
                'attr' => [
                    'class' => 'w-full px-4 py-2 text-lg font-semibold border text-white kw-bg-yellow rounded-md shadow transform hover:scale-105 transition-all duration-500 focus:outline-none',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanContactUs::class,
        ]);
    }
}
