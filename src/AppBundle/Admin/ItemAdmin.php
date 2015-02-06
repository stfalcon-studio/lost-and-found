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
                ->add('areaMap', 'area_map', [
                    'mapped' => false,
                ])
                ->add('area', 'text', [
                    'required' => false,
                ])
                ->add('areaType', 'text')
                ->add('status')
                ->add('moderated')
                ->add('createdBy')
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
            ->add('type', 'string', [
                'template' => 'backend/item/list_type.html.twig',
            ])
            ->add('status', 'string', [
                'template' => 'backend/item/list_status.html.twig',
            ])
            ->add('moderated')
            ->add('date', 'date', [
                'format' => 'd.m.Y'
            ])
            ->add('createdAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('updatedAt', 'datetime', [
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('createdBy')
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
            ->add('area', 'text', [
                'template' => 'backend/item/show_map.html.twig'
            ])
            ->add('areaType')
            ->add('status')
            ->add('moderated', 'boolean')
            ->add('date', 'date', [
                'format' => 'd.m.Y'
            ])
            ->add('createdBy')
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
            ->add('areaType')
            ->add('status')
            ->add('moderated')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('moderatedAt')
            ->add('date');
    }

    /**
     * {@inheritdoc}
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['mark_as_moderated'] = [
            'label'            => 'Mark as moderated',
            'ask_confirmation' => true
        ];
        $actions['unmark_as_moderated']    = [
            'label'            => 'Unmark as moderated',
            'ask_confirmation' => true
        ];

        return $actions;
    }

    /**
     * @param string $name Name
     *
     * @return null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'backend\item\list.html.twig';
                break;
            case 'show':
                return 'backend\item\show.html.twig';
                break;

            case 'edit':
                return 'backend\item\edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
