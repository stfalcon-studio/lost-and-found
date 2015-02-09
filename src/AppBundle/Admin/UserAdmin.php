<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * User Entity Admin
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class UserAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'user';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_user';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('User')
                ->add('username')
                ->add('fullName')
                ->add('email')
                ->add('enabled')
                ->add('lastLogin')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('fullName')
            ->add('email')
            ->add('enabled', null, [
                'editable' => true
            ])
            ->add('lastLogin')
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => [],
                    'delete' => []
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('username')
            ->add('fullName')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('username')
            ->add('fullName')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin');
    }
}
