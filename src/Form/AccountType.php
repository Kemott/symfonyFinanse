<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, ['label' => 'Opis'])
            ->add('bank', TextType::class, ['label' => 'Nazwa banku (jeśli dotyczy)', 'required' => false])
            ->add('account_number', TextType::class, ['label' => 'Numer konta bankowego (jeśli dotyczy)', 'required' => false])
            ->add('amount', MoneyType::class, ['label' => 'Kwota na koncie', 'currency' => "PLN"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
