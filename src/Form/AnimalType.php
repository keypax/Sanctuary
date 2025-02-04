<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animal_id')
            ->add('animal_name')
            ->add('species')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
