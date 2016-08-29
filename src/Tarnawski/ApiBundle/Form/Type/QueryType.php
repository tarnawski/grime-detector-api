<?php

namespace Tarnawski\ApiBundle\Form\Type;

use Tarnawski\ApiBundle\Model\Query;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextType::class);
        $builder->add('output', ChoiceType::class, [
            'choices'  => ['simple', 'complex']
        ]);
        $builder->add('threshold', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Query::class
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
