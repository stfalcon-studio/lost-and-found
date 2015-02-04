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
                ->add('moderated')
                ->add('date', 'date')
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
            ->add('moderated', 'boolean', [
                'editable'=>true,
            ])
            ->add('date', 'date', [
                'format' => 'd.m.Y'
            ])
            ->add('createdAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('updatedAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => []
                ]
            ]);

        $this->setTemplate('list', 'backend\item\list.html.twig');
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
            ->add('moderated', 'boolean')
            ->add('date', 'date', [
                'format' => 'd.m.Y'
            ])
            ->add('createdAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('updatedAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('moderatedAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ]);
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
            ->add('moderated')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('moderatedAt')
            ->add('date');
    }
}
