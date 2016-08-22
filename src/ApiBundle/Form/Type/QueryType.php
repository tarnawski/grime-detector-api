<?php

namespace ApiBundle\Form\Type;

use ApiBundle\Model\Query;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextType::class);
        $builder->add('language', TextType::class);
        $builder->add('correct', CheckboxType::class, [
            'value' => false
        ]);
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
