<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DeleteOldItemsCommand
 *
 * @author Yuri Svatok <svatok13@gmail.com>
 */
class DeleteOldItemsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:old-items:delete')
            ->setDescription('Delete old items')
            ->addArgument(
                'days',
                InputArgument::REQUIRED,
                'Set age of items to be deleted'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $days = $input->getArgument('days');
        if (intval($days)) {
            $days  = new \DateInterval('P'.$days.'D');
            $limit = (new \DateTime())->sub($days);

            $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

            $items = $em->getRepository('AppBundle:Item')->findAllNotDeletedBeforeDate($limit);

            if (!empty($items)) {
                $output->writeln('<info>'.count($items).' items were removed:</info>');

                foreach ($items as $item) {
                    $item->setDeleted(true);
                    $em->refresh($item);
                    $output->writeln($item->getTitle().'|'.$item->getType());
                }

                $em->flush();
            } else {
                $output->writeln('<info>Items with such age was not found</info>');
            }
        } else {
            $output->writeln('<error>Parameter must be integer</error>');
        }
    }
}
