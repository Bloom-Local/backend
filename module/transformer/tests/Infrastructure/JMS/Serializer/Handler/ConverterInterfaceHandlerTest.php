<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See license.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Value\Tests\Infrastructure\JMS\Serializer\Handler;

use Ergonode\Transformer\Infrastructure\Converter\CollectionConverter;
use Ergonode\Transformer\Infrastructure\Converter\ConstConverter;
use Ergonode\Transformer\Infrastructure\Converter\ConverterInterface;
use Ergonode\Transformer\Infrastructure\Converter\DateConverter;
use Ergonode\Transformer\Infrastructure\Converter\DictionaryConverter;
use Ergonode\Transformer\Infrastructure\Converter\JoinConverter;
use Ergonode\Transformer\Infrastructure\Converter\MappingConverter;
use Ergonode\Transformer\Infrastructure\Converter\SlugConverter;
use Ergonode\Transformer\Infrastructure\Converter\SplitConverter;
use Ergonode\Transformer\Infrastructure\Converter\TextConverter;
use Ergonode\Transformer\Infrastructure\Converter\TranslationConverter;
use Ergonode\Transformer\Infrastructure\JMS\Serializer\Handler\ConverterInterfaceHandler;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;

/**
 */
class ConverterInterfaceHandlerTest extends TestCase
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        $handler = new ConverterInterfaceHandler();
        $handler->set(TextConverter::class);
        $handler->set(TranslationConverter::class);
        $handler->set(SlugConverter::class);
        $handler->set(JoinConverter::class);
        $handler->set(DateConverter::class);
        $handler->set(ConstConverter::class);
        $handler->set(MappingConverter::class);
        $handler->set(CollectionConverter::class);
        $handler->set(DictionaryConverter::class);
        $handler->set(SplitConverter::class);

        $this->serializer = SerializerBuilder::create()
            ->configureHandlers(function (HandlerRegistry $handlerRegistry) use ($handler) {
                $handlerRegistry->registerSubscribingHandler($handler);
            })
            ->build();
    }

    /**
     */
    public function testConfiguration(): void
    {
        $configurations = ConverterInterfaceHandler::getSubscribingMethods();
        foreach ($configurations as $configuration) {
            $this->assertArrayHasKey('direction', $configuration);
            $this->assertArrayHasKey('type', $configuration);
            $this->assertArrayHasKey('format', $configuration);
            $this->assertArrayHasKey('method', $configuration);
        }
    }

    /**
     */
    public function testDeserializeTextConverter(): void
    {
        $testValue = '{"type":"text","field":"test_field"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(TextConverter::class, $result);
        $this->assertEquals(TextConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeTranslationConverter(): void
    {
        $testValue = '{"type":"translation","translations":{"PL":"test"}}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(TranslationConverter::class, $result);
        $this->assertEquals(TranslationConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeSlugConverter(): void
    {
        $testValue = '{"type":"slug","field":"test_field"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(SlugConverter::class, $result);
        $this->assertEquals(SlugConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeJoinConverter(): void
    {
        $testValue = '{"type":"join","pattern":"<%s>"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(JoinConverter::class, $result);
        $this->assertEquals(JoinConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeDateConverter(): void
    {
        $testValue = '{"type":"date","format":"Y-m-d","field":"test_field"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(DateConverter::class, $result);
        $this->assertEquals(DateConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeConstConverter(): void
    {
        $testValue = '{"type":"const","value":"CONST"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(ConstConverter::class, $result);
        $this->assertEquals(ConstConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeMappingConverter(): void
    {
        $testValue = '{"type":"mapping","map":{"field":"value"},"field":"test_field"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(MappingConverter::class, $result);
        $this->assertEquals(MappingConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeCollectionConverter(): void
    {
        $testValue = '{"type":"collection","fields":["first","second"]}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(CollectionConverter::class, $result);
        $this->assertEquals(CollectionConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeDictionaryConverter(): void
    {
        $testValue = '{"type":"dictionary","translations":{"PL":"first"},"field":"test_field"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(DictionaryConverter::class, $result);
        $this->assertEquals(DictionaryConverter::TYPE, $result->getType());
    }

    /**
     */
    public function testDeserializeSplitConverter(): void
    {
        $testValue = '{"type":"split","delimiter":",","field":"test_field"}';

        /** @var ConverterInterface $result */
        $result = $this->serializer->deserialize($testValue, ConverterInterface::class, 'json');

        $this->assertInstanceOf(SplitConverter::class, $result);
        $this->assertEquals(SplitConverter::TYPE, $result->getType());
    }
}
