<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Form;

use App\Entity\Country;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * User type
 */
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'user.username'])
            ->add('email', EmailType::class, ['label' => 'user.email'])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'label' => 'user.country',
            ])
            ->add('new_password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'different_passwords',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options' => ['label' => 'pages.user_page.label_new_password'],
                'second_options' => ['label' => 'pages.user_page.label_new_password_repeat'],
            ])
            ->add('save', SubmitType::class, ['label' => 'actions.save'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
