<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AjouterUnChapitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titre_chapitre', TextType::class,
            [
                'label' => 'Titre Chapitre',
                'required' => true,
                'constraints' => [],
                'attr'=>['maxlength'=>38, 'minlength'=>8]
            ])
        ->add('numero_chapitre', IntegerType::class,
            [
                'label' => 'Numero Chapitre',
                'required' => true,
                'constraints' => [],
                'attr'=>['maxlength'=>4, 'minlength'=>1]
            ])
        ->add('date_fin', TextType::class,
            [
                'label' => 'Date de fin estimee',
                'required' => true,
                'constraints' => [],
                'attr'=>['placeholder'=>'format : 01/03/21','maxlength'=>8, 'minlength'=>8],

            ])
        ->add('description', TextareaType::class,
            [
                'label' => 'Description du chapitre ',
                'required' => true,
                'constraints' => [],
                'attr'=>['maxlenth' => 254,'minlength' => 20]
            ])
        ->add('status_chapitre', ChoiceType::class, [
            'label' => 'Statut Chapitre',
            'choices' => [
                'Listes des Status' => [
                    'En cours' => 'En cours',
                    'Termine' => 'Termine',
                ]
            ],
        ])
            ->add('image', FileType::class,[
                'label'=>'cover du chapitre',
                'mapped' =>false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize'=> '30000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/svg+xml',
                        ],
                        'mimeTypesMessage'=> 'Ce fichier n\'est pas valide'
                    ])
                ]
            ])
        ->add('upload_scan', FileType::class,[
            'label'=>'Ajouter un scan',
            'mapped' =>false,
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize'=> '30000k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg',
                        'image/jpg',
                        'image/gif',
                        'image/svg+xml',
                    ],
                    'mimeTypesMessage'=> 'Ce fichier n\'est pas valide'
                ])
            ]
        ])
        ->add('Enregistrer', SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
