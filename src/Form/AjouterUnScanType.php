<?php

namespace App\Form;

use App\Entity\KanbanScan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AjouterUnScanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ScanImages', FileType::class,[
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
            ->add('Ajouter', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KanbanScan::class,
        ]);
    }
}
