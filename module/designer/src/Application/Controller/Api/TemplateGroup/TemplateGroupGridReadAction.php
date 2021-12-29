<?php

/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Designer\Application\Controller\Api\TemplateGroup;

use Ergonode\Core\Domain\ValueObject\Language;
use Ergonode\Grid\Renderer\GridRenderer;
use Ergonode\Grid\RequestGridConfiguration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Ergonode\Grid\Factory\DbalDataSetFactory;
use Ergonode\Designer\Domain\Query\TemplateGroupGridQueryInterface;
use Ergonode\Grid\GridBuilderInterface;

/**
 * @Route("/templates/groups", methods={"GET"})
 */
class TemplateGroupGridReadAction
{
    private TemplateGroupGridQueryInterface $query;

    private GridBuilderInterface $gridBuilder;

    private DbalDataSetFactory $factory;

    private GridRenderer $gridRenderer;

    public function __construct(
        TemplateGroupGridQueryInterface $query,
        GridBuilderInterface $gridBuilder,
        DbalDataSetFactory $factory,
        GridRenderer $gridRenderer
    ) {
        $this->query = $query;
        $this->gridBuilder = $gridBuilder;
        $this->factory = $factory;
        $this->gridRenderer = $gridRenderer;
    }

    /**
     * @SWG\Tag(name="Designer")
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     required=true,
     *     default="50",
     *     description="Number of returned lines",
     * )
     * @SWG\Parameter(
     *     name="offset",
     *     in="query",
     *     type="integer",
     *     required=true,
     *     default="0",
     *     description="Number of start line",
     * )
     * @SWG\Parameter(
     *     name="field",
     *     in="query",
     *     required=false,
     *     type="string",
     *     enum={"id", "label","code", "hint"},
     *     description="Order field",
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     required=false,
     *     type="string",
     *     enum={"ASC","DESC"},
     *     description="Order",
     * )
     * @SWG\Parameter(
     *     name="filter",
     *     in="query",
     *     required=false,
     *     type="string",
     *     description="Filter"
     * )
     * @SWG\Parameter(
     *     name="view",
     *     in="query",
     *     required=false,
     *     type="string",
     *     enum={"grid","list"},
     *     description="Specify respons format"
     * )
     * @SWG\Parameter(
     *     name="language",
     *     in="path",
     *     type="string",
     *     required=true,
     *     default="en_GB",
     *     description="Language Code",
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns list of designer template groups",
     * )
     *
     * @ParamConverter(class="Ergonode\Grid\RequestGridConfiguration", name="configuration")
     */
    public function __invoke(Language $language, RequestGridConfiguration $configuration): array
    {
        $grid = $this->gridBuilder->build($configuration, $language);
        $dataSet = $this->factory->create($this->query->getGridQuery());

        return $this->gridRenderer->render($grid, $configuration, $dataSet);
    }
}
