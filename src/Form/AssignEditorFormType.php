<?php

namespace App\Form;

use App\Command\AssignEditorCommand;
use App\Form\Type\EditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignEditorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('editor', EditorType::class, [
                'required' => true
            ])
            ->add('save', SubmitType::class, [
                    'label' => 'Submit']
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AssignEditorCommand::class,
        ]);
    }
}
