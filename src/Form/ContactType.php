<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Votre prénom',
                    'class' => 'form-control mb-2 text-white',
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Votre nom',
                    'class' => 'form-control mb-2 text-white',
                ]
            ])
            ->add('phone', TextType::class,[
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '0600000000',
                    'class' => 'form-control mb-2 text-white',
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Adresse de messagerie',
                'attr' => [
                    'placeholder' => 'Votre adresse de messagerie / email',
                    'class' => 'form-control mb-2 text-white',
                ]
            ])
            ->add('message', TextareaType::class,[
                'label' => 'Message',
                'label_attr'=> [
                    'class'=> 'text-white'
                ],
                'attr' => [
                    'placeholder' => 'Votre message',
                    'class' => 'form-control mb-2 text-white',
                ]
            ])
            ->add('envoyer', SubmitType::class, [
                'attr'=> [
                    'class' => 'btn btn-primary mb-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'data_class' => Contact::class
        ]);
    }
}
