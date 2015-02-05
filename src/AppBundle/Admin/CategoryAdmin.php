<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Category Entity Admin
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author svatok13
 */
class CategoryAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'category';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_category';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Category')
                ->add('title')
                ->add('enabled')
                ->add('imageFile', 'file', [
                    'required' => false,
                ])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('enabled', 'boolean', [
                'editable' => true,
            ])
            ->add('Image', 'string', [
                'template' => 'backend/category/list_marker.html.twig',
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
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('Image', 'string', [
                'template' => 'backend/category/show_marker.html.twig'
            ])
            ->add('enabled', 'boolean')
            ->add('createdAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('updatedAt', 'datetime', [
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
            ->add('title')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['mark_as_enabled'] = [
            'label'            => 'Enable',
            'ask_confirmation' => true
        ];
        $actions['unmark_as_enabled']    = [
            'label'            => 'Disable',
            'ask_confirmation' => true
        ];

        return $actions;
    }
}
