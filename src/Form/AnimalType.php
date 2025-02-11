<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnimalType extends AbstractType
{
    public function __construct(private ParameterBagInterface $params) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animal_id')
            ->add('animal_name')
            ->add('species', ChoiceType::class, [
                'choices' => array_combine($this->params->get('animal_species'), $this->params->get('animal_species')),
                'choice_translation_domain' => 'messages'
            ])
            ->add('breed')
            ->add('gender')
            ->add('birth_date', null, [
                'widget' => 'single_text',
            ])
            ->add('approximate_age')
            ->add('description')
            ->add('color')
            ->add('distinctive_marks')
            ->add('size')
            ->add('admission_date', null, [
                'widget' => 'single_text',
            ])
            ->add('adoption_status')
            ->add('adoption_date', null, [
                'widget' => 'single_text',
            ])
            ->add('chip_number')
            ->add('weight')
            ->add('animal_photos', CollectionType::class, [
                'entry_type' => AnimalPhotoType::class,
                'label' => 'Zdjęcia',
                'allow_add' => true, // Pozwala na dodawanie nowych elementów do kolekcji
                'allow_delete' => true, // Pozwala na usuwanie elementów z kolekcji
                'prototype' => true, // Włącza prototyp dla JavaScript (jeśli chcesz dynamicznie dodawać pola)
                'by_reference' => false, // Ważne, aby kolekcja była poprawnie aktualizowana
                'required' => false,
                'entry_options' => ['label' => false],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
