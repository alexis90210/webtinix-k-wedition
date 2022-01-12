<?php

namespace App\Form;

use App\Entity\KanbanManga;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUnMangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('titreManga', TextType::class,
                [
                    'label' => 'Titre Manga  (optionel)',
                    'required' => false,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>5]
                ])
            ->add('AuteurManga', TextType::class,
                [
                    'label' => 'auteur (optionel)',
                    'required' => false,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>5]
                ])
            ->add('statusManga', ChoiceType::class, [
                'label' => 'Statut Manga (optionel)',
                'choices' => [
                    'Listes des Status' => [
                        '---' => null,
                        'En cours' => 'En cours',
                        'Termine' => 'Termine',
                    ]
                ],
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanManga::class,
        ]);
    }
}
