<?php

namespace App\Form;

use App\Command\UploadManuscriptCommand;
use App\Entity\Manuscript;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadManuscriptFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('name')
            ->add('location', FileType::class, ['label' => 'Manuscript (PDF file)'])
            ->add('save', SubmitType::class, array('label' => 'Submit'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UploadManuscriptCommand::class,
        ]);
    }
}
