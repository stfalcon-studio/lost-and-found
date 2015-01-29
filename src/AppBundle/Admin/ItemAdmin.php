<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Item Entity Admin
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ItemAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'item';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_item';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Item')
                ->add('category')
                ->add('title')
                ->add('latitude')
                ->add('longitude')
                ->add('type')
                ->add('description')
                ->add('area')
                ->add('status')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('category')
            ->add('type', 'string', ['template' => 'backend/item/list_type.html.twig'])
            ->add('status', 'string', ['template' => 'backend/item/list_status.html.twig'])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
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
            ->add('category')
            ->add('title')
            ->add('latitude')
            ->add('longitude')
            ->add('type')
            ->add('description')
//            ->add('area')
            ->add('status')
            ->add('createdAt')
            ->add('updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('category')
            ->add('title')
            ->add('latitude')
            ->add('longitude')
            ->add('type')
            ->add('description')
            ->add('area')
            ->add('status')
            ->add('createdAt')
            ->add('updatedAt');
    }
}
