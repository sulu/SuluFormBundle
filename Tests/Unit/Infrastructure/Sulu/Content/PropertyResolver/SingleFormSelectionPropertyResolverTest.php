<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Unit\Infrastructure\Sulu\Content\PropertyResolver;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\PropertyResolver\SingleFormSelectionPropertyResolver;
use Sulu\Content\Application\ContentResolver\Value\ResolvableResource;
use Symfony\Component\Form\FormView;

class SingleFormSelectionPropertyResolverTest extends TestCase
{
    public function testResolveReturnsNullContentForNonNumeric(): void
    {
        $resolver = new SingleFormSelectionPropertyResolver();

        $result = $resolver->resolve('not-a-number', 'en', []);

        $this->assertNull($result->getContent());
    }

    public function testResolveClosureMapsStructToFormView(): void
    {
        $resolver = new SingleFormSelectionPropertyResolver();

        $result = $resolver->resolve('5', 'en', []);
        $resolvable = $result->getContent();

        $this->assertInstanceOf(ResolvableResource::class, $resolvable);

        $formView = new FormView();
        $this->assertSame($formView, $resolvable->executeResourceCallback(['view' => $formView, 'entity' => []]));
        $this->assertNull($resolvable->executeResourceCallback(['view' => null, 'entity' => []]));
    }

    public function testGetType(): void
    {
        $this->assertSame('single_form_selection', SingleFormSelectionPropertyResolver::getType());
    }
}
