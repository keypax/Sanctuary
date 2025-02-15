<?php

namespace App\Form;

use App\Entity\Animal;
use App\Service\BreedsProvider\BreedsProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnimalType extends AbstractType
{
    public function __construct(
        private ParameterBagInterface $params,
        private BreedsProviderInterface $breedsProvider
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animal_id')
            ->add('animal_name')
            ->add('species', ChoiceType::class, [
                'choices' => array_combine($this->params->get('animal_species'), $this->params->get('animal_species')),
                'choice_translation_domain' => 'messages'
            ])
            ->add('breed', TextType::class, [
                'attr' => [
                    'list' => 'breed-list',
                    'autocomplete' => 'off'
                ],
                'required' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'gender.unknown' => 0,
                    'gender.male' => 1,
                    'gender.female' => 2,
                ],
                'choice_translation_domain' => 'messages',
                'required' => true,
            ])
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
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
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
