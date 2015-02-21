<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\DBAL\Types\ItemAreaTypeType;
use AppBundle\Entity\Item;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * ItemAreaValidator
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class ItemAreaValidator extends ConstraintValidator
{
    /**
     * Check if item area is valid
     *
     * @param Item       $item       Item
     * @param Constraint $constraint Constraint
     */
    public function validate($item, Constraint $constraint)
    {
        if ($item->getAreaType()) {
            switch ($item->getAreaType()) {
                case ItemAreaTypeType::MARKER:
                    if (!$item->getLatitude() || !$item->getLongitude()) {
                        $this->buildMessage(ItemAreaTypeType::MARKER, $constraint);
                    }
                    break;
                default:
                    if (!$item->getArea()) {
                        $this->buildMessage($item->getAreaType(), $constraint);
                    }
                    break;
            }
        } else {
            $this->buildMessage('figure', $constraint);
        }
    }

    /**
     * Build message
     *
     * @param string     $replacedMessage Replaced message
     * @param Constraint $constraint      Constraint
     */
    private function buildMessage($replacedMessage, Constraint $constraint)
    {
        return $this->context
            ->buildViolation($constraint->message)
            ->setParameter('%areaType%', $replacedMessage)
            ->addViolation();
    }
}
