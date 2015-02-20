<?php

namespace AppBundle\Service;

use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

/**
 * StatisticBlockService
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class StatisticBlockService extends BaseBlockService
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Statistic';
    }

    /**
     * @return array
     */
    public function getDefaultSettings()
    {
        return array();
    }

    /**
     * @param ErrorElement   $errorElement
     * @param BlockInterface $block
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * @param FormMapper     $formMapper
     * @param BlockInterface $block
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @param BlockContextInterface $blockContext
     * @param Response              $response
     *
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = array_merge($this->getDefaultSettings(), $blockContext->getSettings());

        return $this->renderResponse(':backend:block_admin_list.html.twig', [
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ], $response);
    }
}
