<?php

namespace App\Form;

use App\Entity\Mails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
                'trim' => true
            ])
            ->add('email', TextType::class, [
                'label' => 'Votre email',
                'trim' => true
            ])
            ->add('tel', TextType::class, [
                'label' => 'Votre téléphone (facultatif)',
                'required' =>false,
                'trim' => true
            ])
            ->add('object', TextType::class, [
                'label' => 'Objet (facultatif)',
                'required' =>false,
                'trim' => true
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu du message',
                'trim' => true
            ])
            ->add('part', HiddenType::class)
                
        ;

        
        $builder->get('name') 
            ->addModelTransformer(new CallbackTransformer(
                function ($originalName) {
                    return preg_replace('#<br\s*/?>#i', "\n", $originalName);
                },
                function ($submittedName) {
                    $cleaned = strip_tags($submittedName, '<br><br/><p>');
                    return str_replace("\n", '<br/>', $cleaned);
                }
            ))
        ;
        $builder->get('email')
            ->addModelTransformer(new CallbackTransformer(
                function ($originalEmail) {
                    return preg_replace('#<br\s*/?>#i', "\n", $originalEmail);
                },
                function ($submittedEmail) {
                    $cleaned = strip_tags($submittedEmail, '<br><br/><p>');
                    return str_replace("\n", '<br/>', $cleaned);
                }
            ))
        ;
        $builder->get('tel')
            ->addModelTransformer(new CallbackTransformer(
                function ($originalTel) {
                    return preg_replace('#<br\s*/?>#i', "\n", $originalTel);
                },
                function ($submittedTel) {
                    $cleaned = strip_tags($submittedTel, '<br><br/><p>');
                    return str_replace("\n", '<br/>', $cleaned);
                }
            ))
        ;
        $builder->get('object')
            ->addModelTransformer(new CallbackTransformer(
                function ($originalObject) {
                    return preg_replace('#<br\s*/?>#i', "\n", $originalObject);
                },
                function ($submittedObject) {
                    $cleaned = strip_tags($submittedObject, '<br><br/><p>');
                    return str_replace("\n", '<br/>', $cleaned);
                }
            ))
        ;
        $builder->get('content')
            ->addModelTransformer(new CallbackTransformer(
                function ($originalContent) {
                    return preg_replace('#<br\s*/?>#i', "\n", $originalContent);
                },
                function ($submittedContent) {
                    $cleaned = strip_tags($submittedContent, '<br><br/><p>');
                    return str_replace("\n", '<br/>', $cleaned);
                }
            ))

        ;        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mails::class,
        ]);
    }
}
