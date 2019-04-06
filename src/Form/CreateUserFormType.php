<?php

namespace App\Form;

use App\Command\CreateUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('surname')
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password'
            ])
            ->add('addressLineOne')
            ->add('addressLineTwo')
            ->add('city')
            ->add('county')
            ->add('postcode')
            ->add('country')
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
