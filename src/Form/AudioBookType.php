<?php

namespace App\Form;

use App\Entity\AudioBook;

use App\Entity\IsInvolvedIn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AudioBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('stock')
            ->add('isInvolvedIns', CollectionType::class,
                [
                    'entry_type' => IsInvolvedInType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ])
            ->add('title')
            ->add('format')
            ->add('productCode')
            ->add('duration')


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AudioBook::class,
        ]);
    }
}
