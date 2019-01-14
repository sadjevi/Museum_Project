<?php

namespace SA\MuseumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('bookedat',       DateType::class, array('label' => 'Commande éffectuée le'))
            ->add('ticketsnbr',  IntegerType::class, array('label' => 'Merci de confirmer le nombre de billets réservés'))
            ->add('mail',          EmailType::class, array('label' => 'Adresse mail'))

            ->add ('tickets', CollectionType::class, array(
                'entry_type'   =>             TicketType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ))


            ->add('Reservation',  SubmitType::class);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SA\MuseumBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sa_museumbundle_booking';
    }


}
