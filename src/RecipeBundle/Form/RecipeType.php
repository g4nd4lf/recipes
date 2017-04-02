<?php

namespace RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('summary', TextareaType::class, ['attr' => ['rows' => 5]])
            ->add('method', TextareaType::class, ['attr' => ['rows' => 10]])
            ->add('ingredients', TextareaType::class, ['attr' => ['rows' => 10]])
            ->add('servings')
            ->add('prepTime')
            ->add('cookingTime')
            ->add('tags');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RecipeBundle\Entity\Recipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'recipe';
    }
}
