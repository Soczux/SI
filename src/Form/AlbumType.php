<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'album.title'])
            ->add('logo', FileType::class, [
                'label' => 'album.cover',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/apng',
                            'image/avif',
                            'image/svg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Akceptujemy tylko pliki graficzne',
                    ]),
                ],
            ])
            ->add('artist', EntityType::class, [
                'label' => 'album.artist',
                'class' => Artist::class,
            ])
            ->add('save', SubmitType::class, ['label' => 'actions.save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
