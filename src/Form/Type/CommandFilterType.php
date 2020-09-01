<?php

namespace App\Form\Type;

use App\Form\Model\CommandFilterForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('all', ChoiceType::class, [
                'required' => true,
                 'label' => false,
                 'choices' => [
                     'Wszystkie' => '1',
                     'Wybrane' => '0',
                 ],
                 'expanded' => true
            ])
            ->add('asyncChatThread', CheckboxType::class, ['required' => false])
            ->add('serverThread', CheckboxType::class, ['required' => false])
//            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommandFilterForm::class,
            'csrf_token_id'   => 'command_filter_token',
        ]);
    }
}
