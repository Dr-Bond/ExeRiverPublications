<?php

namespace App\Form;

use App\Command\AddNoteCommand;
use App\Form\Type\NoteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddNoteFormType
 * @package App\Form
 */
class AddNoteFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noteType', NoteType::class, [
                'required' => true
            ])
            ->add('content', TextareaType::class, [
                'required' => true
            ])
            ->add('save', SubmitType::class, [
                    'label' => 'Submit']
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AddNoteCommand::class,
        ]);
    }
}
