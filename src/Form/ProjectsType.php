<?php

namespace App\Form;

use App\Entity\Projets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('structure_name')
            ->add('header_structure')
            ->add('catchy_sentence')
            ->add('presentation_paragraph')
            ->add('presentation_pict')
            ->add('context_paragraph')
            ->add('context_pict')
            ->add('explain_paragraph')
            ->add('framework_name')
            ->add('framework_pict')
            ->add('result_picture')
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
