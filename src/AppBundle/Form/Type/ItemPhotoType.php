<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ItemPhotoType
 *
 * @author Artem Genvald      <GenvaldArtem@gmail.com>
 * @author Yuri Svatok        <Svatok13@gmail.com>
 */
class ItemPhotoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', 'file', [
                'required' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'cascade_validation' => true,
            'data_class' => 'AppBundle\Entity\ItemPhoto'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'photo';
    }
}
