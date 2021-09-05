<?php

namespace App\Form;

use App\Entity\SongComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SongCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                TextareaType::class,
                [
                    'required' => true,
                    'attr' => ['max_length' => 1000],
                    'label' => 'comment.content',
                ]
            )
            ->add('comment_add', SubmitType::class, ['label' => 'actions.comment'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SongComment::class,
        ]);
    }
}
