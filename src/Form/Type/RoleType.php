<?php

namespace App\Form\Type;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $roles = [
            Role::ROLE_ADMIN['desc'] => Role::ROLE_ADMIN['id'],
            Role::ROLE_AGENT['desc'] => Role::ROLE_AGENT['id'],
            Role::ROLE_AUTHOR['desc'] => Role::ROLE_AUTHOR['id'],
            Role::ROLE_EDITOR['desc'] => Role::ROLE_EDITOR['id'],
            Role::ROLE_REVIEWER['desc'] => Role::ROLE_REVIEWER['id']
        ];

        $resolver->setDefaults([
            'choices' => $roles,
            'placeholder' => 'Please select',
            'required' => true
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}