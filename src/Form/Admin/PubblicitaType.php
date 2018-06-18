<?php
namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Admin\Pubblicita;

class PubblicitaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('compagnia', TextType::class)
            ->add('posizione', ChoiceType::class, array(
                  'multiple'=> true,
                  'label' => 'posizione',
                  'choices' => array(
                    'home' =>'home',
                    'categoria' =>'categoria',
                    'articolo' =>'articolo',
            )))
            ->add('active', ChoiceType::class, array(
                  'label' => 'active',
                  'choices' => array(
                    'attivo' =>'0',
                    'non attivo' =>'1',
            )))
            ->add('script', TextareaType::class, array(
              'attr' => array('cols' => '5', 'rows' => '5'),
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Pubblicita::class,
        ));
    }
}
