<?php

namespace App\Form;

use App\Entity\Outcome;
use App\Entity\Category;
use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class OutcomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new \DateTime();
        $builder
        ->add('outcomeDate', DateType::class, [
            'label' => 'Data powstania kosztu',
            'widget' => 'single_text',
            'html5' => true,
            'input' => 'datetime',
            'data' => $now
        ])
        ->add('description', TextType::class, ['label' => 'Opis kosztu'])
        ->add('amount', MoneyType::class, ['label' => 'Kwota (brutto)', 'currency' => "PLN"])
        ->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'name',
            'label' => 'Kategoria kosztu'
        ])
        ->add('account', EntityType::class, [
            'class' => Account::class,
            'choice_label' => 'description',
            'label' => 'Konto'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Outcome::class,
        ]);
    }
}
