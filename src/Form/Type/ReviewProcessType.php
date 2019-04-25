<?php

namespace App\Form\Type;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ReviewProcessType
 * @package App\Form\Type
 */
class ReviewProcessType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = [
            Book::REJECTED_STATUS => Book::REJECTED_STATUS,
            Book::ACCEPTED_STATUS => Book::ACCEPTED_STATUS
        ];

        $resolver->setDefaults([
            'choices' => $choices,
            'placeholder' => 'Please select',
            'required' => true
        ]);
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}