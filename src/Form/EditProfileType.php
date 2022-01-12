<?php

namespace App\Form;

use App\Entity\KanbanUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', FileType::class,[
                'label'=>'Avatar',
                'mapped' =>false,
                'required' => false,
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
            ->add('pseudo', TextType::class,
                [
                    'label' => 'Nouveau Pseudo',
                    'required' => true,
                    'constraints' => [],
                    'attr'=>['maxlength'=>10, 'minlength'=>4]
                ])


            ->add('Enregistrer', SubmitType::class,[

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
