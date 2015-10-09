<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
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
 * Category Entity Admin
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
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

        $actions['enable_action']  = [
            'label'            => 'Enable',
            'ask_confirmation' => true,
        ];
        $actions['disable_action'] = [
            'label'            => 'Disable',
            'ask_confirmation' => true,
        ];

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Administrative')
                ->with(null)
                    ->add('parent')
                    ->add('enabled', 'checkbox', [
                        'required' => false,
                    ])
                    ->add('imageFile', 'file', [
                        'required' => false,
                    ])
                ->end()
            ->end()
            ->tab('Translations')
                ->with(null)
                    ->add('translations', 'a2lix_translations_gedmo', [
                        'translatable_class' => 'AppBundle\Entity\Category',
                        'fields' => [
                            'title' => [
                                'locale_options' => [
                                    'uk' => [
                                        'required' => true,
                                    ],
                                    'en' => [
                                        'required' => true,
                                    ],
                                    'ru' => [
                                        'required' => true,
                                    ],
                                ],
                            ],
                        ],
                    ])
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
            ->add('parent')
            ->add('enabled', 'boolean', [
                'editable' => true,
            ])
            ->add('image', 'string', [
                'template' => 'backend/category/list_marker.html.twig',
            ])
            ->add('createdAt', 'datetime', [
                'format' => 'd.m.Y H:i:s',
            ])
            ->add('updatedAt', 'datetime', [
                'format' => 'd.m.Y H:i:s',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => [],
                ],
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
            ->add('parent')
            ->add('image', 'string', [
                'template' => 'backend/category/show_marker.html.twig',
            ])
            ->add('enabled', 'boolean')
            ->add('children')
            ->add('createdAt', 'datetime', [
                'format' => 'd.m.Y H:i:s',
            ])
            ->add('updatedAt', 'datetime', [
                'format' => 'd.m.Y H:i:s',
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
            ->add('parent')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt');
    }
}
