<?php

namespace App\Form;

use App\Entity\Animal;
use App\Service\Animal\Provider\Breed\BreedsProviderInterface;
use App\Service\Animal\Provider\Species\SpeciesProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function __construct(
        private ParameterBagInterface $params,
        private SpeciesProviderInterface $speciesProvider,
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $species = $this->speciesProvider->getSpecies();

        $builder
            ->add('animal_id')
            ->add('animal_name')
            ->add('species', ChoiceType::class, [
                'choices' => array_combine($species, $species),
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
            ->add('approximate_age', ChoiceType::class, [
                'label' => 'approximate_age.label',
                'choices' => [
                    'approximate_age.less_than_week' => 0,
                    'approximate_age.1_2_weeks' => 7,
                    'approximate_age.2_4_weeks' => 14,
                    'approximate_age.1_month' => 30,
                    'approximate_age.2_months' => 60,
                    'approximate_age.3_months' => 90,
                    'approximate_age.4_months' => 120,
                    'approximate_age.5_months' => 150,
                    'approximate_age.6_months' => 180,
                    'approximate_age.7_months' => 210,
                    'approximate_age.8_months' => 240,
                    'approximate_age.9_months' => 270,
                    'approximate_age.10_months' => 300,
                    'approximate_age.11_months' => 330,
                    'approximate_age.1_year' => 365,
                    'approximate_age.1_2_years' => 365,
                    'approximate_age.2_3_years' => 730,
                    'approximate_age.3_4_years' => 1095,
                    'approximate_age.4_5_years' => 1460,
                    'approximate_age.5_7_years' => 1825,
                    'approximate_age.7_10_years' => 2555,
                    'approximate_age.senior' => 3650,
                ],
                'choice_translation_domain' => 'messages',
                'required' => false,
            ])
            ->add('description')
            ->add('color')
            ->add('distinctive_marks')
            ->add('size', ChoiceType::class, [
                'label' => 'size.label',
                'choices' => [
                    'animal.size.very_small' => 0,
                    'animal.size.small' => 1,
                    'animal.size.medium' => 2,
                    'animal.size.large' => 3,
                    'animal.size.very_large' => 4,
                ],
                'choice_translation_domain' => 'messages',
                'required' => true,
            ])
            ->add('admission_date', null, [
                'widget' => 'single_text',
            ])
            ->add('adoption_status', ChoiceType::class, [
                'label' => 'adoption_status.label',
                'choices' => $this->params->get('adoption_status'),
                'choice_translation_domain' => 'messages',
                'required' => false,
            ])
            ->add('adoption_date', null, [
                'widget' => 'single_text',
            ])
            ->add('chip_number')
            ->add('weight', NumberType::class, [
                'label' => 'weight_in_grams',
                'html5' => true,
                'attr' => [
                    'min' => '0',
                    'step' => '1000',
                    'inputmode' => 'numeric', 'pattern' => '\d+(\.\d+)?'
                ],
            ])
            /*->add('animal_photos', CollectionType::class, [
                'entry_type' => AnimalPhotoType::class,
                'label' => 'animal.photos.title',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'required' => false,
                'entry_options' => ['label' => false],
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
