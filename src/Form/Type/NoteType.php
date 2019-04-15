<?php

namespace App\Form\Type;

use App\Entity\Book;
use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $notes = [
            Note::MEETING_NOTE_TYPE => Note::MEETING_NOTE_TYPE,
            Note::PHONE_CALL_NOTE_TYPE => Note::PHONE_CALL_NOTE_TYPE
        ];

        $resolver->setDefaults([
            'choices' => $notes,
            'placeholder' => 'Please select',
            'required' => true
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}