<?php

namespace App\Form;

use App\Command\CreateUserCommand;
use App\Form\Type\RoleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true
            ])
            ->add('surname', TextType::class, [
                'required' => true
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'required' => true
            ])
            ->add('role', RoleType::class, [
                'required' => true
            ])
            ->add('addressLineOne', TextType::class,  [
                'required' => true
            ])
            ->add('addressLineTwo', TextType::class)
            ->add('city', TextType::class, [
                'required' => true
            ])
            ->add('county', TextType::class, [
                'required' => true
            ])
            ->add('postcode', TextType::class, [
                'required' => true
            ])
            ->add('country', TextType::class, [
                'required' => true
            ])
            ->add('save', SubmitType::class, array('label' => 'Create User'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreateUserCommand::class,
        ]);
    }
}
