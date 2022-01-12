<?php

namespace App\Form;

use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\NumericFilterType;
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

class AjouterUnMangaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre_manga', TextType::class,
                [
                    'label' => 'Titre Manga',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>5]
                ])
            ->add('auteur', TextType::class,
                [
                    'label' => 'auteur',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>5]
                ])
            ->add('genre', TextType::class,
                [
                    'label' => 'Genre',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['placeholder'=>'genre1/genre2/...'],
                    'attr'=>['maxlength'=>30, 'minlength'=>5]
                ])
            ->add('status_manga', ChoiceType::class, [
                'label' => 'Statut Manga',
                'choices' => [
                    'Listes des Status' => [
                        'En cours' => 'En cours',
                        'Termine' => 'Termine',
                    ]/*,
                    'Out of Stock Statuses' => [
                        'Backordered' => 'stock_backordered',
                        'Discontinued' => 'stock_discontinued',
                    ],*/
                ],
            ])

            ->add('decouverte', ChoiceType::class, [
                'label' => 'Est ce une decouverte ?',
                'choices' => [
                    'faites votre choix' => [
                        'Non' => 'false',
                        'Oui' => 'true',
                    ]/*,
                    'Out of Stock Statuses' => [
                        'Backordered' => 'stock_backordered',
                        'Discontinued' => 'stock_discontinued',
                    ],*/
                ],
            ])
            ->add('manga_cover', FileType::class,[
                'label'=>'cover du manga',
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
            ->add('profile_manga', FileType::class,[
                'label'=>'profile du manga',
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
            ->add('titre_chapitre', TextType::class,
                [
                    'label' => 'Titre Chapitre',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>30, 'minlength'=>5]
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
            ->add('status_chapitre', ChoiceType::class, [
                'label' => 'Statut Chapitre',
                'choices' => [
                    'Listes des Status' => [
                        'En cours' => 'En cours',
                        'Termine' => 'Termine',
                    ]/*,
                    'Out of Stock Statuses' => [
                        'Backordered' => 'stock_backordered',
                        'Discontinued' => 'stock_discontinued',
                    ],*/
                ],
            ])
            ->add('upload_scan', FileType::class,[
                'label'=>false,
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
