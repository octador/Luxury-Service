<?php

namespace App\Form;

use App\Entity\Candidat;
use App\Entity\Experience;
use App\Entity\Gender;
use App\Entity\JobCategory;
use App\Entity\Media;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('adress')
            ->add('country')
            ->add('nationality')
            ->add('brithDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('birthPlace')
            ->add('shortDescription')
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('deletedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('adminNote')
            ->add('isAvailable')
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'choice_label' => 'gender',
            ])
            ->add('passport', EntityType::class, [
                'class' => Media::class,
                'choice_label' => 'id',
            ])
            ->add('cv', EntityType::class, [
                'class' => Media::class,
                'choice_label' => 'id',
            ])
            ->add('profilPicture', EntityType::class, [
                'class' => Media::class,
                'choice_label' => 'id',
            ])
            ->add('jobCategory', EntityType::class, [
                'class' => JobCategory::class,
                'choice_label' => 'id',
            ])
            ->add('experience', EntityType::class, [
                'class' => Experience::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
