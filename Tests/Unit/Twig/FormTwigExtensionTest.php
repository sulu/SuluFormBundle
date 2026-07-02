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

namespace Sulu\Bundle\FormBundle\Tests\Unit\Twig;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Twig\FormTwigExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class FormTwigExtensionTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var BuilderInterface|ObjectProphecy
     */
    private $formBuilder;

    private FormTwigExtension $extension;

    protected function setUp(): void
    {
        $this->formBuilder = $this->prophesize(BuilderInterface::class);

        $this->extension = new FormTwigExtension(
            $this->formBuilder->reveal()
        );
    }

    public function testGetFunctionsExposesExpectedFunctions(): void
    {
        $names = \array_map(static fn ($function) => $function->getName(), $this->extension->getFunctions());

        $this->assertContains('sulu_form_get_by_id', $names);
    }

    public function testGetFormByIdReturnsNullWhenBuilderReturnsNull(): void
    {
        $this->formBuilder->build(7, 'page', 'tpl', 'en', 'form')
            ->shouldBeCalledOnce()
            ->willReturn(null);

        $this->assertNull($this->extension->getFormById(7, 'page', 'tpl', 'en'));
    }

    public function testGetFormByIdReturnsView(): void
    {
        $view = new FormView();
        $formInterface = $this->prophesize(FormInterface::class);
        $formInterface->createView()->willReturn($view);

        $this->formBuilder->build(7, 'page', 'tpl', 'en', 'form')
            ->shouldBeCalledOnce()
            ->willReturn($formInterface->reveal());

        $this->assertSame($view, $this->extension->getFormById(7, 'page', 'tpl', 'en'));
    }
}
