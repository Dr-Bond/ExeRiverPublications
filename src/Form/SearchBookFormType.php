<?php

namespace App\Form;

use App\Command\SearchBookCommand;
use App\Form\Type\SearchStatusType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SearchBookFormType
 * @package App\Form
 */
class SearchBookFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchBookCommand::class
        ]);
    }
}
