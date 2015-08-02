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

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

/**
 * Class DirectoryNamerService
 *
 * @author Yuri Svatok <svatok13@gmail.com>
 */
class DirectoryNamerService implements DirectoryNamerInterface
{
    /**
     * {@inheritdoc}
     */
    public function directoryName($object, PropertyMapping $mapping)
    {
        /** @var \DateTime $date */
        $date = $object->getCreatedAt();

        return $date->format('Y').'/'.$date->format('m').'/'.$date->format('d');
    }
}
