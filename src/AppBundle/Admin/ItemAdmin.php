<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Item Entity Admin
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Oleg Kachinsky     <logansoleg@gmail.com>
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
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['mark_as_moderated_action']   = [
            'label'            => 'Mark as moderated',
            'ask_confirmation' => true
        ];
        $actions['unmark_as_moderated_action'] = [
            'label'            => 'Unmark as moderated',
            'ask_confirmation' => true
        ];

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'backend\item\list.html.twig';
            case 'show':
                return 'backend\item\show.html.twig';
            case 'edit':
                return 'backend\item\edit.html.twig';
            default:
                return parent::getTemplate($name);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('General')
                ->with(null)
                    ->add('category')
                    ->add('title')
                    ->add('description')
                    ->add('date', 'sonata_type_date_picker')
                    ->add('type')
                    ->add('status')
                ->end()
            ->end()
            ->tab('Admin')
                ->with(null)
                    ->add('moderated', 'checkbox', [
                        'required' => false,
                    ])
                    ->add('createdBy')
                    ->add('deleted', 'checkbox', [
                        'required' => false,
                    ])
                ->end()
            ->end()
            ->tab('Requests')
                ->with(null)
                    ->add('userRequests')
                ->end()
            ->end()
            ->tab('Map')
                ->with(null)
                    ->add('latitude', 'hidden')
                    ->add('longitude', 'hidden')
                    ->add('areaMap', 'area_map', [
                        'mapped' => false,
                    ])
//                    ->add('areaType', 'text')
//                    ->add('area', 'text', [
//                        'required' => false,
//                    ])
                ->end()
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
            ->add('areaType')
            ->add('status', 'string', [
                'template' => 'backend/item/list_status.html.twig',
            ])
            ->add('moderated', null, [
                'editable' => true
            ])
            ->add('active', null, [
                'editable' => true
            ])
            ->add('deleted', null, [
                'editable' => true
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
            ->add('photos', 'string', [
                'template' => 'backend/item/photos_list.html.twig'
            ])
            ->add('area', 'text', [
                'template' => 'backend/item/show_map.html.twig'
            ])
            ->add('areaType')
            ->add('status')
            ->add('activatedAt')
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
            ])
            ->add('deleted')
            ->add('deletedAt')
            ->add('userRequests');
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
            ->add('activatedAt')
            ->add('moderated')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('moderatedAt')
            ->add('date')
            ->add('deleted')
            ->add('deletedAt');
    }
}
