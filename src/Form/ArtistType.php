<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Form;

use App\DataTransformer\ArtistTagDataTransformer;
use App\Entity\Artist;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Artist type
 */
class ArtistType extends AbstractType
{
    private ArtistTagDataTransformer $artistTagDataTransformer;

    /**
     * @param ArtistTagDataTransformer $artistTagDataTransformer
     */
    public function __construct(ArtistTagDataTransformer $artistTagDataTransformer)
    {
        $this->artistTagDataTransformer = $artistTagDataTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'artist.name'])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'label' => 'artist.country',
            ])
            ->add('tags', TextType::class, [
                'required' => false,
                'label' => 'artist.tags',
            ])
            ->add('save', SubmitType::class, ['label' => 'actions.save'])
        ;

        $builder->get('tags')->addModelTransformer($this->artistTagDataTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
