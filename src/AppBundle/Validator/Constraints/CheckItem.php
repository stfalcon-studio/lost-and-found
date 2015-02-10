<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class CheckItemType
 *
 * @Annotation
 */
class CheckItem extends Constraint
{
    public $message = 'Check the "%areaType%" on map';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'check_item';
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}