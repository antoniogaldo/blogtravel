<?php
namespace App\Form\Admin;

use App\Entity\Admin\Articolicategoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticolicategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class)
            ->add('data', DateType::class, array(
              'widget' => 'single_text',
              'format' => 'yyyy-MM-dd',))
            ->add('active', ChoiceType::class, array(
                  'label' => 'active',
                  'choices' => array(
                    'attivo' =>'0',
                    'non attivo' =>'1',
            )))
            ->add('image', FileType::class, array(
              'required' => false,
              'label' => 'Immagine',
              'data_class' => null))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Articolicategoria::class,
        ));
    }
}
