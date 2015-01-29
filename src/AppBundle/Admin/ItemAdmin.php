<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ItemAdmin
 * @package AppBundle\Admin
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
            ->add('category')
            ->addIdentifier('title')
          //  ->add('latitude')
          //  ->add('longitude')
            ->add('type')
           // ->add('description')
//            ->add('area')
            ->add('status')
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
}