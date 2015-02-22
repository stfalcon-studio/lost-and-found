<?php

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
     * Set created by user
     *
     * @param User $createdBy Created by user
     *
     * @return $this
     */
    public function setCreatedBy(User $createdBy);

    /**
     * Get created by user
     *
     * @return User Created by user
     */
    public function getCreatedBy();
}
