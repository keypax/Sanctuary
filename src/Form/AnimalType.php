<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Enclosure;
use App\Service\Animal\Choice\ChoicesServiceInterface;
use App\Service\Animal\Choice\Exception\ChoicesProviderException;
use App\Service\Animal\Provider\Species\SpeciesProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function __construct(
        private readonly SpeciesProviderInterface $speciesProvider,
        private readonly ChoicesServiceInterface $choicesService,
        private readonly LoggerInterface $logger
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $species = $this->speciesProvider->getSpecies();

        $builder
            ->add('animal_internal_id')
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
                'choices' => $this->getChoices('gender'),
                'choice_translation_domain' => 'messages',
                'required' => true,
            ])
            ->add('birth_date', null, [
                'widget' => 'single_text',
            ])
            ->add('approximate_age', ChoiceType::class, [
                'label' => 'approximate_age.label',
                'choices' => $this->getChoices('approximate_age'),
                'choice_translation_domain' => 'messages',
                'required' => false,
            ])
            ->add('description')
            ->add('color')
            ->add('distinctive_marks')
            ->add('size', ChoiceType::class, [
                'label' => 'size.label',
                'choices' => $this->getChoices('size'),
                'choice_translation_domain' => 'messages',
                'required' => true,
            ])
            ->add('admission_date', null, [
                'widget' => 'single_text',
            ])
            ->add('adoption_status', ChoiceType::class, [
                'label' => 'adoption_status.label',
                'choices' => $this->getChoices('adoption_status'),
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
                'required' => false,
            ])
            ->add('enclosure', EntityType::class, [
                'class' => Enclosure::class,
                'choice_label' => 'enclosure_name',
                'label' => 'enclosure.label',
                'choice_translation_domain' => 'messages',
                'required' => false,
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

    private function getChoices(string $key): array
    {
        try {
            return $this->choicesService->getProviderByKey($key)->getChoices();
        } catch (ChoicesProviderException $e) {
            $this->logger->error($e->getMessage());
            return [];
        }
    }
}
