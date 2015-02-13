<?php

namespace AppBundle\Service;

use AppBundle\Entity\Item;
use Doctrine\ORM\EntityManager;


/**
 * GeoService
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class GeoService
{
    /**
     * @var EntityManager $entityManager Entity manager
     */
    private $entityManager;

    /**
     * @param EntityManager $em Entity manager
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * Search found matches
     *
     * @return array
     */
    public function searchFoundMatches()
    {
        $itemRepository = $this->entityManager->getRepository('AppBundle:Item');

        $foundItems = $itemRepository->getFoundItems();
        $lostItems = $itemRepository->getLostItems();

        $foundMatches = [];
        $numbersFound = [];

        for ($i = 0; $i < count($foundItems); $i++) {
            for ($j = 0; $j < count($lostItems); $j++) {
                if ($foundItems[$i]['categoryId'] == $lostItems[$j]['categoryId']) {
                    if ($this->calculateDistanceBetweenMarkers(
                        $foundItems[$i]['latitude'],
                        $foundItems[$i]['longitude'],
                        $lostItems[$j]['latitude'],
                        $lostItems[$j]['longitude']
                    ) < 1
                    ) {
                        $numbersFound[$j] = $lostItems[$j]['id'];;
                    }
                }
            }
            $foundMatches[$i] = $numbersFound;
            $numbersFound = [];
        }

        return $foundMatches;
    }

    /**
     * Search lost matches
     *
     * @return array
     */
    public function searchLostMatches()
    {
        $itemRepository = $this->entityManager->getRepository('AppBundle:Item');

        $foundItems = $itemRepository->getFoundItems();
        $lostItems = $itemRepository->getLostItems();

        $lostMatches = [];
        $numbersLost = [];

        for ($i = 0; $i < count($lostItems); $i++) {
            for ($j = 0; $j < count($foundItems); $j++) {
                if ($lostItems[$i]['categoryId'] == $foundItems[$j]['categoryId']) {
                    if ($this->calculateDistanceBetweenMarkers(
                        $lostItems[$i]['latitude'],
                        $lostItems[$i]['longitude'],
                        $foundItems[$j]['latitude'],
                        $foundItems[$j]['longitude']
                    ) < 1
                    ) {
                        $numbersLost[$j] = $foundItems[$j]['id'];
                    }
                }
            }
            $lostMatches[$i] = $numbersLost;
            $numbersLost = [];
        }

        return $lostMatches;
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     *
     * @param float $latitudeFrom  Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo    Latitude of target point in [deg decimal]
     * @param float $longitudeTo   Longitude of target point in [deg decimal]
     * @param int   $earthRadius   Mean earth radius in [km]
     *
     * @return float Distance between points in [km] (same as earthRadius)
     */
    private function calculateDistanceBetweenMarkers(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
