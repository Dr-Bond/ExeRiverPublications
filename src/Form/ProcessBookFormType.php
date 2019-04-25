<?php

namespace App\Form;

use App\Command\ProcessBookCommand;
use App\Form\Type\ProcessType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProcessBookFormType
 * @package App\Form
 */
class ProcessBookFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('feedback', TextareaType::class, [
                'required' => true
            ])
            ->add('process', ProcessType::class, [
                'required' => true
            ])
            ->add('rating', ChoiceType::class, [
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ],
                'required' => true
            ])
            ->add('amount', MoneyType::class, [
                'required' => false,
                'label' => 'Payment amount'
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
            'data_class' => ProcessBookCommand::class
        ]);
    }
}
