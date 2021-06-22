<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Song;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'maxSizeMessage' => 'Maksymalny rozmiar pliku to 20MB',
                        'mimeTypes' => [
                            'audio/mpeg',
                        ],
                        'mimeTypesMessage' => 'Akceptujemy tylko pliki w formacie MPEG',
                    ]),
                ],
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
            ])
            ->add('add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
        ]);
    }
}
