<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * FAQ Entity Admin
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Artem Genvald      <genvaldartem@gmail.com>
 */
class FaqAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'faq';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_faq';

    /**
     * {@inheritdoc}
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['enable_action']  = [
            'label'            => 'Enable',
            'ask_confirmation' => true
        ];
        $actions['disable_action'] = [
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
            ->tab('Administrative')
                ->with(null)
                    ->add('enabled')
                ->end()
            ->end()
            ->tab('Translations')
                ->with(null)
                    ->add('translations', 'a2lix_translations_gedmo', [
                        'translatable_class' => 'AppBundle\Entity\Faq',
                        'fields' => [
                            'question' => [
                                'locale_options' => [
                                    'uk' => [
                                        'required' => true
                                    ],
                                    'en' => [
                                        'required' => true
                                    ],
                                    'ru' => [
                                        'required' => true
                                    ]
                                ]
                            ],
                            'answer' => [
                                'field_type'     => 'ckeditor',
                                'locale_options' => [
                                    'uk' => [
                                        'required' => true
                                    ],
                                    'en' => [
                                        'required' => true
                                    ],
                                    'ru' => [
                                        'required' => true
                                    ]
                                ]
                            ]
                        ]
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
            ->addIdentifier('question')
            ->add('enabled', null, [
                'editable' => true,
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
            ->add('question')
            ->add('answer')
            ->add('translations')
            ->add('enabled')
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
    protected function configureDataGridFilters(DataGridMapper $dataGridMapper)
    {
        $dataGridMapper
            ->add('id')
            ->add('question')
            ->add('answer')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt');
    }
}
