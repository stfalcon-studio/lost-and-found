<?php

namespace AppBundle\Model;

use AppBundle\Entity\User;

/**
 * Interface UserManageableInterface
 *
 * @author Artem Genvald  <GenvaldArtem@gmail.com>
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
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
