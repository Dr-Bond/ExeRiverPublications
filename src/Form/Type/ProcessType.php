<?php

namespace App\Form\Type;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcessType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = [
            Book::REVISION_REQUIRED_STATUS => Book::REVISION_REQUIRED_STATUS,
            Book::PUBLISHED_STATUS => Book::PUBLISHED_STATUS
        ];

        $resolver->setDefaults([
            'choices' => $choices,
            'placeholder' => 'Please select',
            'required' => true
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}