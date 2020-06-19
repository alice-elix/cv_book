<?php

namespace App\Form;

use App\Entity\Projets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('structure_name', TextType::class, [
                'label' => 'Nom de la structure'
            ])
            ->add('header_structure', TextType::class, [
                'label' => 'Qlqs mots pour décrire la structure'
            ])
            ->add('catchy_sentence', TextType::class, [
                'label' => 'Phrase d\'accroche'
            ])
            ->add('presentation_paragraph', TextareaType::class, [
                'label' => 'Résumé rapide du projet'
            ])
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
            ->add('context_paragraph', TextareaType::class, [
                'label' => 'Paragraphe de contextualisation du projet'
            ])
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
            ->add('explain_paragraph', TextareaType::class, [
                'label' => 'Paragraphe de présentation du projet (outils, équipe...)'
            ])
            ->add('framework_name', TextareaType::class, [
                'label' => 'Noms des technos'
            ])
            ->add('framework_pict', FileType::class, [
                'label' => 'Logos des technos',
                'mapped' => false,
                'required' => false,
                'multiple'=>true                
            ])
            ->add('result_picture', FileType::class, [
                'label' => 'Photos du résultat',
                'mapped' => false,
                'required' => false,
                'multiple'=>true                
            ])
            ->add('result_paragraph', TextareaType::class, [
                'label' => 'Paragraphe de présentation du résultat'
            ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projets::class,
        ]);
    }
}
