<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\Item;
use Doctrine\ORM\EntityManager;
use Location\Coordinate;
use Location\Distance\Vincenty;

/**
 * GeoService
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 * @author Artem Genvald  <genvaldartem@gmail.com>
 */
class GeoService
{
    /**
     * @var EntityManager $entityManager Entity manager
     */
    private $entityManager;

    /**
     * Constructor
     *
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

        $foundItems = $itemRepository->getItemsJoinCategories(ItemTypeType::FOUND);
        $lostItems  = $itemRepository->getItemsJoinCategories(ItemTypeType::LOST);

        $foundMatches = [];
        $numbersFound = [];

        for ($i = 0; $i < count($foundItems); $i++) {
            switch ($foundItems[$i]['areaType']) {
                case 'polygon':
                case 'rectangle':
                    $area = json_decode($foundItems[$i]['area'], true);

                    $latitudeArray  = [];
                    $longitudeArray = [];

                    for ($j = 0; $j < count($area); $j++) {
                        $latitudeArray[$j] = $area[$j]['latitude'];
                        $longitudeArray[$j] = $area[$j]['longitude'];
                    }

                    for ($j = 0; $j < count($lostItems); $j++) {
                        if ($foundItems[$i]['categoryId'] == $lostItems[$j]['categoryId']) {
                            if ($this->isPointInPolygon(
                                count($area),
                                $latitudeArray,
                                $longitudeArray,
                                $lostItems[$j]['latitude'],
                                $lostItems[$j]['longitude']
                            )) {
                                $numbersFound[count($numbersFound)] = $lostItems[$j]['id'];
                            }
                        }
                    }
                    break;
                case 'circle':
                    $area = json_decode($foundItems[$i]['area'], true);
                    $area = $area[0];

                    for ($j = 0; $j < count($lostItems); $j++) {
                        if ($foundItems[$i]['categoryId'] == $lostItems[$j]['categoryId']) {
                            if ($this->getDistance(
                                $area['latlng']['lat'],
                                $area['latlng']['lng'],
                                $lostItems[$j]['latitude'],
                                $lostItems[$j]['longitude']
                            ) < $area['radius']) {
                                $numbersFound[count($numbersFound)] = $lostItems[$j]['id'];
                            }
                        }
                    }
                    break;
                case 'marker':
                    for ($j = 0; $j < count($lostItems); $j++) {
                        if ($foundItems[$i]['categoryId'] == $lostItems[$j]['categoryId']) {
                            if ($this->getDistance(
                                $foundItems[$i]['latitude'],
                                $foundItems[$i]['longitude'],
                                $lostItems[$j]['latitude'],
                                $lostItems[$j]['longitude']
                            ) < 1) {
                                $numbersFound[count($numbersFound)] = $lostItems[$j]['id'];
                            }
                        }
                    }
                    break;
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

        $foundItems = $itemRepository->getItemsJoinCategories(ItemTypeType::FOUND);
        $lostItems  = $itemRepository->getItemsJoinCategories(ItemTypeType::LOST);

        $lostMatches = [];
        $numbersLost = [];

        for ($i = 0; $i < count($lostItems); $i++) {
            switch ($lostItems[$i]['areaType']) {
                case 'polygon':
                case 'rectangle':
                    $area = json_decode($lostItems[$i]['area'], true);

                    $latitudeArray = [];
                    $longitudeArray = [];

                    for ($j = 0; $j < count($area); $j++) {
                        $latitudeArray[$j]  = $area[$j]['latitude'];
                        $longitudeArray[$j] = $area[$j]['longitude'];
                    }

                    for ($j = 0; $j < count($foundItems); $j++) {
                        if ($lostItems[$i]['categoryId'] == $foundItems[$j]['categoryId']) {
                            if ($this->isPointInPolygon(
                                count($area),
                                $latitudeArray,
                                $longitudeArray,
                                $foundItems[$j]['latitude'],
                                $foundItems[$j]['longitude']
                            )) {
                                $numbersLost[count($numbersLost)] = $foundItems[$j]['id'];
                            }
                        }
                    }
                    break;
                case 'circle':
                    $area = json_decode($lostItems[$i]['area'], true);
                    $area = $area[0];

                    for ($j = 0; $j < count($foundItems); $j++) {
                        if ($lostItems[$i]['categoryId'] == $foundItems[$j]['categoryId']) {
                            if ($this->getDistance(
                                $area['latlng']['lat'],
                                $area['latlng']['lng'],
                                $foundItems[$j]['latitude'],
                                $foundItems[$j]['longitude']
                            ) < $area['radius']) {
                                $numbersLost[count($numbersLost)] = $foundItems[$j]['id'];
                            }
                        }
                    }
                    break;
                case 'marker':
                    for ($j = 0; $j < count($foundItems); $j++) {
                        if ($lostItems[$i]['categoryId'] == $foundItems[$j]['categoryId']) {
                            if ($this->getDistance(
                                $lostItems[$i]['latitude'],
                                $lostItems[$i]['longitude'],
                                $foundItems[$j]['latitude'],
                                $foundItems[$j]['longitude']
                            ) < 1) {
                                $numbersLost[count($numbersLost)] = $foundItems[$j]['id'];
                            }
                        }
                    }
                    break;
            }
            $lostMatches[$i] = $numbersLost;
            $numbersLost = [];
        }

        return $lostMatches;
    }

    /**
     * PNPOLY algorithm - Point Inclusion in Polygon Test.
     * W. Randolph Franklin (WRF)
     *
     * @param int   $countTop
     * @param array $latitudeArray
     * @param array $longitudeArray
     * @param float $latitudeMarker
     * @param float $longitudeMarker
     *
     * @return bool
     */
    public function isPointInPolygon($countTop, $latitudeArray, $longitudeArray, $latitudeMarker, $longitudeMarker)
    {
        $result = false;

        for ($i = 0, $j = $countTop - 1; $i < $countTop; $j = $i++) {
            if ((
                    ($longitudeArray[$i] > $longitudeMarker) != ($longitudeArray[$j] > $longitudeMarker)
                ) && (
                    $latitudeMarker < ($latitudeArray[$j] - $latitudeArray[$i]) * ($longitudeMarker - $longitudeArray[$i]) /
                    ($longitudeArray[$j] - $longitudeArray[$i]) + $latitudeArray[$i]
                )
            ) {
                $result = !$result;
            }
        }

        return $result;
    }

    /**
     * Calculates the great-circle distance between two points, with the Vincenty formula
     *
     * @param float $latitudeX  Latitude of start point in [deg decimal]
     * @param float $longitudeX Longitude of start point in [deg decimal]
     * @param float $latitudeY  Latitude of target point in [deg decimal]
     * @param float $longitudeY Longitude of target point in [deg decimal]
     *
     * @return float Distance between points in [km] (same as earthRadius)
     */
    private function getDistance($latitudeX, $longitudeX, $latitudeY, $longitudeY)
    {
        return (new Vincenty())->getDistance(
            new Coordinate($latitudeX, $longitudeX),
            new Coordinate($latitudeY, $longitudeY)
        );
    }
}
