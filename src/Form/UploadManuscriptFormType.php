<?php

namespace App\Form;

use App\Command\UploadManuscriptCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UploadManuscriptFormType
 * @package App\Form
 */
class UploadManuscriptFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true
            ])
            ->add('location', FileType::class, [
                'label' => 'Manuscript (PDF file)',
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
            'data_class' => UploadManuscriptCommand::class,
        ]);
    }
}
