<?php

namespace App\Form;

use App\Command\AddBookCommand;
use App\Form\Type\AgentType;
use App\Form\Type\AuthorType;
use App\Form\Type\ReviewerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'required' => true
            ])
            ->add('name', TextType::class,  [
                'required' => true
            ])
            ->add('author', AuthorType::class, [
                'required' => true
            ])
            ->add('agent', AgentType::class, [
                'required' => true
            ])
            ->add('mainReviewer', ReviewerType::class, [
                'required' => true
            ])
            ->add('secondaryReviewer', ReviewerType::class)
            ->add('save', SubmitType::class, [
                    'label' => 'Submit']
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AddBookCommand::class,
        ]);
    }
}
