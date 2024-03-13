<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url')
            ->add('name', FileType:: class, [
                 // unmapped means that this field is not associated to any entity property
                 'mapped' => true,
                 'required' => false,

                 // unmapped fields can't define their validation using attributes
                 // in the associated entity, so you can use the PHP constraint classes
                 'constraints' => [
                     new File([
                         'maxSize' => '1024k',
                         'mimeTypes' => [
                             'application/pdf',
                             'application/x-pdf',
                         ],
                         'mimeTypesMessage' => 'Please upload a valid PDF document',
                     ])
                 ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
