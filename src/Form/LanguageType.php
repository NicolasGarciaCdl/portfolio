<?php

namespace App\Form;

use App\Entity\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> 'Nom',
                'attr'=> [
                    'placeholder' => 'Nom du langage',
                    'class' => 'form-control'
                ]
            ])
            ->add('picture', TextType::class, [
                'label'=> 'nom de l\'image',
                'attr'=> [
                    'placeholder' => 'Nom de l\'image',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Language::class,
        ]);
    }
}
