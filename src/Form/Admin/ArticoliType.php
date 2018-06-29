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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticoliType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titolo', TextType::class)
            ->add('tags', ChoiceType::class, array(
                  'multiple'=> true,
                  'label' => 'tags',
                  'choices' => array(
                    'itinerari' =>'itinerari',
                    'adventure' =>'adventure',
                    'food' =>'food',
                    'tecnologia' =>'tecnologia',
                    'cultura' =>'cultura',
                    'hobby' =>'hobby',
                    'trasporto' =>'trasporto',
                    'classifica' =>'classifica',
            )))
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
            ->add('articolo', TextareaType::class, array(
              'attr' => array('cols' => '5', 'rows' => '5'),
            ))
            ->add('autore', TextType::class)
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
