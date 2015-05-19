<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DeleteOldItemsCommand
 *
 * @author Yuri Svatok
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
        $days = new \DateInterval('P'.$input->getArgument('days').'D');
        $limit = (new \DateTime())->sub($days);

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $items = $em->getRepository('AppBundle:Item')->findYoungerItemsByDate($limit);
        if (empty($items)) {
            $output->writeln('<info>Items with such age was not found</info>');

            return;
        }

        $output->writeln('<info>'.count($items).' items were removed:</info>');
        foreach ($items as $item) {
            $em->remove($item);
            $output->writeln($item->getTitle().'|'.$item->getType());
        }
        $em->flush();
    }
}
