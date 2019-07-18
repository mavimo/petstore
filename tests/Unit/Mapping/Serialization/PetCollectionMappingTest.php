<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mapping\Serialization;

use App\Collection\PetCollection;
use App\Mapping\Serialization\AbstractCollectionMapping;
use App\Mapping\Serialization\PetCollectionMapping;
use Chubbyphp\Framework\Router\RouterInterface;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingInterface;

/**
 * @covers \App\Mapping\Serialization\PetCollectionMapping
 *
 * @internal
 */
final class PetCollectionMappingTest extends CollectionMappingTest
{
    use MockByCallsTrait;

    /**
     * @param string $path
     *
     * @return NormalizationFieldMappingInterface[]
     */
    protected function getNormalizationFieldMappings(string $path): array
    {
        $mappings = parent::getNormalizationFieldMappings($path);
        $mappings[] = NormalizationFieldMappingBuilder::create('name')->getMapping();

        return $mappings;
    }

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return PetCollection::class;
    }

    /**
     * @return string
     */
    protected function getNormalizationType(): string
    {
        return 'petCollection';
    }

    /**
     * @return string
     */
    protected function getListRoute(): string
    {
        return 'pet_list';
    }

    /**
     * @return string
     */
    protected function getCreateRoute(): string
    {
        return 'pet_create';
    }

    /**
     * @return string
     */
    protected function getCollectionPath(): string
    {
        return '/api/pets';
    }

    /**
     * @param RouterInterface $router
     *
     * @return AbstractCollectionMapping
     */
    protected function getCollectionMapping(RouterInterface $router): AbstractCollectionMapping
    {
        return new PetCollectionMapping($router);
    }
}
