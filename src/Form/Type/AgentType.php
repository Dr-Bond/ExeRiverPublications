<?php

namespace App\Form\Type;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AgentType
 * @package App\Form\Type
 */
class AgentType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'include' => null,
            'class' => User::class,
            'placeholder' => 'Please select',
            'choices' => function(Options $options) {
                return
                    $options['em']->getRepository($options['class'])->findByRoles(Role::ROLE_AGENT['id']);
            }
        ]);
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return EntityType::class;
    }
}
