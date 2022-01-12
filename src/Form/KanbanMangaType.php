<?php

namespace App\Form;

use App\Entity\KanbanManga;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KanbanMangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,
                [
                    'label' => 'Titre du Manga',
                    'required' => true,
                    'constraints' => [],
                    'attr' => [
                        'class' => 'form-control mb-3',
                        'placeholder' => 'Entrez le titre du manga'
                    ]
                ])
            ->add('SUIVANT', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary mt-5',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanManga::class,
        ]);
    }
}
