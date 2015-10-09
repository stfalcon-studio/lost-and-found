<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Model;

use AppBundle\Entity\User;

/**
 * Interface UserManageableInterface
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
interface UserManageableInterface
{
    /**
     * Get created by user
     *
     * @return User Created by user
     */
    public function getCreatedBy();

    /**
     * Set created by user
     *
     * @param User $createdBy Created by user
     *
     * @return $this
     */
    public function setCreatedBy(User $createdBy);
}
