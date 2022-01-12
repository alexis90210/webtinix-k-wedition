<?php

namespace App\Form;

use App\Entity\KanbanCommentaire;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KanbanCommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', TextareaType::class,
                [
                  /*  'label' => 'commentaire',*/
                    'required' => true,
                    'constraints' => [],
                    'attr' => [
                        'class' => 'bg-transparent rounded border leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 
                                ring-gray-300 focus:border-transparent',
                        'placeholder' => 'Entrez votre commentaire',
                        'autofocus' => 'autofocus',
                        'maxlength'=>255, 'minlength'=>2
                    ]

                ])
            ->add('Commenter', SubmitType::class,[
                'attr' => [
                    'class' => 'text-white font-medium py-1 px-4 border tracking-wide mr-1 w-full text-lg kw-bg-yellow rounded-md shadow transform hover:scale-105 transition-all duration-500 focus:outline-none',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanCommentaire::class,
        ]);
    }
}
