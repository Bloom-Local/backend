<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Segment\Domain\Command;

use Ergonode\Condition\Domain\Entity\ConditionSetId;
use Ergonode\Core\Domain\ValueObject\TranslatableString;
use Ergonode\Segment\Domain\Entity\SegmentId;
use JMS\Serializer\Annotation as JMS;

/**
 */
class UpdateSegmentCommand
{
    /**
     * @var SegmentId
     *
     * @JMS\Type("Ergonode\Segment\Domain\Entity\SegmentId")
     */
    private $id;

    /**
     * @var TranslatableString
     *
     * @JMS\Type("Ergonode\Core\Domain\ValueObject\TranslatableString")
     */
    private $name;

    /**
     * @var TranslatableString
     *
     * @JMS\Type("Ergonode\Core\Domain\ValueObject\TranslatableString")
     */
    private $description;

    /**
     * @var ConditionSetId
     */
    private $conditionSetId;

    /**
     * @param SegmentId          $id
     * @param TranslatableString $name
     * @param TranslatableString $description
     * @param ConditionSetId     $conditionSetId
     */
    public function __construct(
        SegmentId $id,
        TranslatableString $name,
        TranslatableString $description,
        ConditionSetId $conditionSetId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->conditionSetId = $conditionSetId;
    }

    /**
     * @return SegmentId
     */
    public function getId(): SegmentId
    {
        return $this->id;
    }

    /**
     * @return TranslatableString
     */
    public function getName(): TranslatableString
    {
        return $this->name;
    }

    /**
     * @return TranslatableString
     */
    public function getDescription(): TranslatableString
    {
        return $this->description;
    }

    /**
     * @return ConditionSetId
     */
    public function getConditionSetId(): ConditionSetId
    {
        return $this->conditionSetId;
    }
}