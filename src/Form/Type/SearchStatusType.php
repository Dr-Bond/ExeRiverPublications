<?php

namespace App\Form\Type;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchStatusType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = [
            Book::REJECTED_STATUS => Book::REJECTED_STATUS,
            Book::PUBLISHED_STATUS => Book::PUBLISHED_STATUS,
            Book::PENDING_MANUSCRIPT_STATUS => Book::PENDING_MANUSCRIPT_STATUS,
            Book::PENDING_REVIEW_STATUS => Book::PENDING_REVIEW_STATUS,
            Book::ACCEPTED_STATUS => Book::ACCEPTED_STATUS,
            Book::PENDING_SECOND_REVIEW_STATUS => Book::PENDING_SECOND_REVIEW_STATUS,
            Book::REVISION_REQUIRED_STATUS => Book::REVISION_REQUIRED_STATUS,
            Book::PENDING_EDITOR_REVIEW_STATUS => Book::PENDING_EDITOR_REVIEW_STATUS
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