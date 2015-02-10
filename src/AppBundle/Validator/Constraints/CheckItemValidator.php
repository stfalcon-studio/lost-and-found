<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\DBAL\Types\ItemAreaTypeType;
use AppBundle\Entity\Item as Item;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class CheckItemValidator
 */
class CheckItemValidator extends ConstraintValidator
{
    /**
     * @param Item       $item
     * @param Constraint $constraint
     */
    public function validate($item, Constraint $constraint)
    {
        if ($item->getAreaType()) {
            switch ($item->getAreaType())
            {
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
            $item->getAreaType('figure', $constraint);
        }
    }

    private function buildMessage($replacedMessage, Constraint $constraint)
    {
        return $this->context
            ->buildViolation($constraint->message)
            ->setParameter('%areaType%', $replacedMessage)
            ->addViolation();
    }
}