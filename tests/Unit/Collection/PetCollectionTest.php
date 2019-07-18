<?php

declare(strict_types=1);

namespace App\Tests\Unit\Collection;

use App\Collection\CollectionInterface;
use App\Collection\PetCollection;

/**
 * @covers \App\Collection\PetCollection
 *
 * @internal
 */
final class PetCollectionTest extends CollectionTest
{
    public function testGetSetName(): void
    {
        $petCollection = new PetCollection();

        self::assertNull($petCollection->getName());

        $petCollection->setName('sample');

        self::assertSame('sample', $petCollection->getName());
    }

    /**
     * @return CollectionInterface
     */
    protected function getCollection(): CollectionInterface
    {
        return new PetCollection();
    }
}
