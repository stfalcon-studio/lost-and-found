<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class SendMessageType
 */
class SendMessageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'text')
            ->add('send', 'submit', [
                'label' => 'Send message',
                'attr'  => [
                    'class' => 'btn-success',
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'send_message';
    }
}
