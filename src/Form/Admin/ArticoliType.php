<?php
namespace App\Form\Admin;

use App\Entity\Admin\Articolicategoria;
use App\Entity\Admin\Articoli;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticoliType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class)
            ->add('data', DateType::class, array(
              'widget' => 'single_text',
              'format' => 'yyyy-MM-dd',))
            ->add('articolo', TextareaType::class, array(
              'attr' => array('cols' => '5', 'rows' => '5'),
            ))
            ->add('categoria', EntityType::class, array(
                 'class' => Articolicategoria::class,
                 'choice_label' => 'nome',
             ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Articoli::class,
        ));
    }
}
