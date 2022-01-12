<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class fileUploaderType extends AbstractType
{
    public function  buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('upload_file', FileType::class,[
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
            ->add('Uploader', SubmitType::class)
            ;
    }

}