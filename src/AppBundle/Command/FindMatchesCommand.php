<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use AppBundle\DBAL\Types\ItemTypeType;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * FindMatchesCommand
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 * @author Artem Genvald  <genvaldartem@gmail.com>
 */
class FindMatchesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:items:find-matches')
            ->setDescription('Find matches between lost and found items.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $geoService = $this->getContainer()->get('geo');

        $itemRepository = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Item');

        $foundItems = $itemRepository->getItemsJoinCategories(ItemTypeType::FOUND);
        $lostItems  = $itemRepository->getItemsJoinCategories(ItemTypeType::LOST);

        $output->writeln('<info>Found Items</info>');

        $foundMatches = $geoService->searchFoundMatches();

        $countFoundMatches = count($foundMatches);
        $countLostItems    = count($lostItems);

        for ($i = 0; $i < $countFoundMatches; $i++) {
            $output->writeln($foundItems[$i]['itemTitle']." ---- ");

            foreach ($foundMatches[$i] as $itemId) {
                for ($j = 0; $j < $countLostItems; $j++) {
                    if ($lostItems[$j]['id'] == $itemId) {
                        $output->writeln("\t ---- ".$lostItems[$j]['itemTitle']);
                    }
                }
            }
        }

        $output->writeln('');
        $output->writeln('<info>Lost Items</info>');

        $lostMatches = $geoService->searchLostMatches();

        $countLostMatches = count($lostMatches);
        $countFoundItems  = count($foundItems);

        for ($i = 0; $i < $countLostMatches; $i++) {
            $output->writeln($lostItems[$i]['itemTitle']." ---- ");

            foreach ($lostMatches[$i] as $itemId) {
                for ($j = 0; $j < $countFoundItems; $j++) {
                    if ($foundItems[$j]['id'] == $itemId) {
                        $output->writeln("\t ---- ".$foundItems[$j]['itemTitle']);
                    }
                }
            }
        }
    }
}
