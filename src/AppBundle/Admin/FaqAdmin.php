<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Admin faq  Entity
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
            ->with('faq')
                ->add('enabled')
                ->add('translations', 'a2lix_translations_gedmo', [
                    'translatable_class' => 'AppBundle\Entity\Faq',
                    'fields' => [
                      'question' => [
                          'label' => 'Питання',
                          'locale_options' => [
                              'ua' => [
                                  'required' => true
                              ],
                              'en' => [
                                  'required' => false
                              ],
                              'ru' => [
                                  'required' => false
                              ]
                          ]
                      ],
                      'answer'=> [
                          'label' => 'Відповідь',
                          'locale_options' => [
                              'ua' => [
                                  'required' => true
                            ],
                              'en' => [
                                  'required' => false
                            ],
                              'ru' => [
                                  'required' => false
                            ]
                        ]
                    ]
                  ]])
                ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('question', null, array('label' => 'Question'))
            ->add('answer', null, array('label' => 'Answer'))
            ->add('enabled', null, [
                'editable' => true,
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
            ->add('enabled');
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
            ->add('enabled');
    }
}
