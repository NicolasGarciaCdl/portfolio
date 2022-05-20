<?php

namespace App\Form;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre de l\'article',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'attr'=> [
                    'placeholder' => 'titre du project',
                    'class'=>'text-white',
                ],
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Contenu de l\'article',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'attr'=> [
                    'placeholder' => 'contenu du project',
                    'class'=>'text-white',
                ],
            ])
            ->add('link_url', TextType::class,[
                'label' => 'Lien de l\'article',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'attr'=> [
                    'placeholder' => 'http://url du project',
                    'class'=>'text-white',
                ],
            ])
            ->add('slug', TextType::class,[
                'label' => 'slug',
                'label_attr' => [
                    'class' => 'text-white'
                ],
                'attr'=> [
                    'placeholder' => 'slug du project',
                    'class'=>'text-white',
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
