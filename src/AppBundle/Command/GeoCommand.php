<?php

namespace AppBundle\Command;

use AppBundle\DBAL\Types\ItemTypeType;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * GeoCommand
 *
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
 */
class GeoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('items:compare')
            ->setDescription('Compare lost and found list of items.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $geo = $this->getContainer()->get('geo');
        $itemRepository = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Item');

        $foundItems = $itemRepository->getItemsJoinCategories(ItemTypeType::FOUND);
        $lostItems = $itemRepository->getItemsJoinCategories(ItemTypeType::LOST);

        $output->writeln('-----------Found Items----------');

        $foundMatches = $geo->searchFoundMatches();

        for ($i = 0; $i < count($foundMatches); $i++) {
            $output->writeln($foundItems[$i]['itemTitle'] . " ---- ");
            foreach ($foundMatches[$i] as $itemId) {
                for ($j = 0; $j < count($lostItems); $j++) {
                    if ($lostItems[$j]['id'] == $itemId) {
                        $output->writeln("\t ---- " . $lostItems[$j]['itemTitle']);
                    }
                }
            }
        }

        $output->writeln("\n-----------Lost Items-----------");

        $lostMatches = $geo->searchLostMatches();

        for ($i = 0; $i < count($lostMatches); $i++) {
            $output->writeln($lostItems[$i]['itemTitle'] . " ---- ");
            foreach ($lostMatches[$i] as $itemId) {
                for ($j = 0; $j < count($foundItems); $j++) {
                    if ($foundItems[$j]['id'] == $itemId) {
                        $output->writeln("\t ---- " . $foundItems[$j]['itemTitle']);
                    }
                }
            }
        }
    }
}
