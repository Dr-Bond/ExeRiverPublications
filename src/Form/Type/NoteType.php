<?php

namespace App\Form\Type;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NoteType
 * @package App\Form\Type
 */
class NoteType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
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

    /**
     * @return null|string
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}