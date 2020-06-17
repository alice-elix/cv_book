<?php

namespace App\Form;

use App\Entity\Projets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('structure_name')
            ->add('header_structure')
            ->add('catchy_sentence')
            ->add('presentation_paragraph')
            ->add('presentation_pict', FileType::class, [
                'label' => 'Photo de présentation',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize'=> '1024k',
                        'mimeTypes'=> [
                            'image/jpg',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Sélectionner un format image PNG, JPG ou JPEG',
                    ])
                ],
            ])
            ->add('context_paragraph')
            ->add('context_pict', FileType::class, [
                'label' => 'Icone d\'illustration',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize'=> '1024k',
                        'mimeTypes'=> [
                            'image/jpg',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Sélectionner un format image PNG, JPG ou JPEG',
                    ])
                ],
            ])
            ->add('explain_paragraph')
            ->add('result_picture', FileType::class, [
                'label' => 'Photos du résultat',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize'=> '1024k',
                        'mimeTypes'=> [
                            'image/jpg',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Sélectionner un format image PNG, JPG ou JPEG',
                    ])
                ],
                
            ])
            ->add('result_paragraph')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projets::class,
        ]);
    }
}
