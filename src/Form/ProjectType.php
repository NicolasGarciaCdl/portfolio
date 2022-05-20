<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=>'Titre',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'attr'=> [
                    'placeholder' => 'titre du project',

                ],
            ])
            ->add('content', TextareaType::class,[
                'label'=>'Contenu',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'attr'=> [
                    'placeholder' => 'contenu du project',
                ]
            ])
            ->add('url', TextType::class,[
                'label'=>'Lien du projet',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'attr'=> [
                    'placeholder' => 'url du project',

                ]
            ])
            ->add('created_at', DateTimeType::class,[
                'label'=> 'crée le',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'widget'=> 'single_text',
                'attr'=> [
                    'placeholder' => 'Date du project',

                ]
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'expanded' =>true,
                'multiple' =>true,
                'choice_label' =>'title',
                'choice_attr'=> [
                    'class' => 'text-white',
                ],
                'mapped' => true,
                'label_attr' => [
        'class' => 'text-white'
    ],
            ])
            ->add('imageFile', VichImageType::class, [
                'required'=> false,
                'label' => 'Image du projet',
                'label_attr' => [
                    'class' => 'text-white'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
