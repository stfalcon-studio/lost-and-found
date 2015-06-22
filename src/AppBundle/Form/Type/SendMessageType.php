<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            ->add('content', 'text', [
                'translation_domain' => 'main-page'
            ])
            ->add('send', 'submit', [
                'label' => 'Send message',
                'attr'  => [
                    'class' => 'btn-success',
                ],
                'translation_domain' => 'main-page'
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
