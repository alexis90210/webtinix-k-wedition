<?php

namespace App\Form;

use App\Entity\KanbanChapitre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUnChapitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TitreChapitre', TextType::class,
                [
                    'label' => 'Nouveau Titre (optionel)',
                    'required' => false,
                    'constraints' => [],
                    'attr'=>['maxlength'=>20, 'minlength'=>3],

                ])
            ->add('dateFinChapitre', TextType::class,
                [
                    'label' => 'Nouvel Date de fin (02/04/24)  (optionel)',
                    'required' => false,
                    'constraints' => [],
                    'attr'=>['maxlength'=>8, 'minlength'=>8]

                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'Description du chapitre  (optionel)',
                    'required' => false,
                    'constraints' => [],
                    'attr'=>['maxlenth' => 254,'minlength' => 20]
                ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanChapitre::class,
        ]);
    }
}
