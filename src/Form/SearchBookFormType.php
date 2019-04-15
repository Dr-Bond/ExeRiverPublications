<?php

namespace App\Form;

use App\Command\SearchBookCommand;
use App\Form\Type\SearchStatusType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', SearchStatusType::class, [
                'required' => true
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Search'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchBookCommand::class
        ]);
    }
}
