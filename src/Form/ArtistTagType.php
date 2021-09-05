<?php

namespace App\Form;

use App\Entity\ArtistTag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'tagName',
                TextType::class,
                [
                    'label' => 'tag_name',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArtistTag::class,
        ]);
    }
}
