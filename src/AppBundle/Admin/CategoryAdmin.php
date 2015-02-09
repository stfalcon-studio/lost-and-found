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
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['enable'] = [
            'label'            => 'Enable',
            'ask_confirmation' => true
        ];
        $actions['disable']    = [
            'label'            => 'Disable',
            'ask_confirmation' => true
        ];

        return $actions;
    }

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
                ->add('parent')
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
            ->add('image', 'string', [
                'template' => 'backend/category/list_marker.html.twig',
            ])
            ->add('parent')
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
            ->add('image', 'string', [
                'template' => 'backend/category/show_marker.html.twig'
            ])
            ->add('enabled', 'boolean')
            ->add('parent')
            ->add('children')
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
            ->add('parent')
            ->add('createdAt')
            ->add('updatedAt');
    }
}
