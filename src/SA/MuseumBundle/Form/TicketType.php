<?php

namespace SA\MuseumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        setlocale(LC_TIME, "fr_FR");
        $builder
            ->add('name',            TextType::class, array('label' => 'Nom'))
            ->add('forename',        TextType::class, array('label' => 'Prénom'))
            ->add('birthdate',   BirthdayType::class, array('placeholder' => 'Select a value','label' => 'Date de naissance'))
            ->add('slot',        CheckboxType::class, array('required' => false,'label' =>'Demi-journée'))
            ->add('bookedday',       DateType::class, array('widget' => 'single_text','label' =>'Date de visite'))
            ->add('country',      CountryType::class, array('label' => 'Pays'))
            ->add('specialrate', CheckboxType::class, array('required' => false,'label' => 'Tarif réduit'));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SA\MuseumBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sa_museumbundle_ticket';
    }


}
