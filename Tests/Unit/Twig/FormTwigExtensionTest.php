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
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Twig\FormTwigExtension;
use Sulu\Component\Localization\Localization;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class FormTwigExtensionTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var BuilderInterface|ObjectProphecy
     */
    private $formBuilder;

    /**
     * @var RequestAnalyzerInterface|ObjectProphecy
     */
    private $requestAnalyzer;

    private FormTwigExtension $extension;

    protected function setUp(): void
    {
        $this->formBuilder = $this->prophesize(BuilderInterface::class);
        $this->requestAnalyzer = $this->prophesize(RequestAnalyzerInterface::class);

        $this->extension = new FormTwigExtension(
            $this->formBuilder->reveal(),
            $this->requestAnalyzer->reveal()
        );
    }

    public function testGetFunctionsExposesExpectedFunctions(): void
    {
        $names = \array_map(static fn ($function) => $function->getName(), $this->extension->getFunctions());

        $this->assertContains('sulu_form_get_by_id', $names);
        $this->assertContains('sulu_form_build', $names);
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

    public function testGetFormByContentReturnsNullWhenEntityMissing(): void
    {
        $this->formBuilder->build(Argument::cetera())->shouldNotBeCalled();

        $this->assertNull($this->extension->getFormByContent([], 'page', 'tpl'));
    }

    public function testGetFormByContentReturnsNullWhenEntityIsNotForm(): void
    {
        $this->formBuilder->build(Argument::cetera())->shouldNotBeCalled();

        $this->assertNull($this->extension->getFormByContent(['entity' => new \stdClass()], 'page', 'tpl'));
    }

    public function testGetFormByContentReturnsNullWhenFormHasNoId(): void
    {
        $form = new Form();
        $form->setDefaultLocale('en');

        $this->formBuilder->build(Argument::cetera())->shouldNotBeCalled();

        $this->assertNull($this->extension->getFormByContent(['entity' => $form], 'page', 'tpl'));
    }

    public function testGetFormByContentUsesExplicitLocale(): void
    {
        $form = $this->createForm(5, ['en', 'de'], 'en');

        $view = new FormView();
        $formInterface = $this->prophesize(FormInterface::class);
        $formInterface->createView()->willReturn($view);

        $this->formBuilder->build(5, 'page', 'tpl', 'de', 'form')
            ->shouldBeCalledOnce()
            ->willReturn($formInterface->reveal());

        $this->requestAnalyzer->getCurrentLocalization()->shouldNotBeCalled();

        $result = $this->extension->getFormByContent(['entity' => $form], 'page', 'tpl', 'de');

        $this->assertSame($view, $result);
    }

    public function testGetFormByContentFallsBackToRequestLocaleWhenTranslationExists(): void
    {
        $form = $this->createForm(5, ['en', 'de'], 'en');

        $this->requestAnalyzer->getCurrentLocalization()
            ->shouldBeCalledOnce()
            ->willReturn(new Localization('de'));

        $view = new FormView();
        $formInterface = $this->prophesize(FormInterface::class);
        $formInterface->createView()->willReturn($view);

        $this->formBuilder->build(5, 'page', 'tpl', 'de', 'form')
            ->shouldBeCalledOnce()
            ->willReturn($formInterface->reveal());

        $result = $this->extension->getFormByContent(['entity' => $form], 'page', 'tpl');

        $this->assertSame($view, $result);
    }

    public function testGetFormByContentFallsBackToDefaultLocaleWhenRequestLocaleHasNoTranslation(): void
    {
        $form = $this->createForm(5, ['en'], 'en');

        $this->requestAnalyzer->getCurrentLocalization()
            ->shouldBeCalledOnce()
            ->willReturn(new Localization('de'));

        $view = new FormView();
        $formInterface = $this->prophesize(FormInterface::class);
        $formInterface->createView()->willReturn($view);

        $this->formBuilder->build(5, 'page', 'tpl', 'en', 'form')
            ->shouldBeCalledOnce()
            ->willReturn($formInterface->reveal());

        $result = $this->extension->getFormByContent(['entity' => $form], 'page', 'tpl');

        $this->assertSame($view, $result);
    }

    public function testGetFormByContentFallsBackToDefaultLocaleWhenNoCurrentLocalization(): void
    {
        $form = $this->createForm(5, ['en'], 'en');

        $this->requestAnalyzer->getCurrentLocalization()
            ->shouldBeCalledOnce()
            ->willReturn(null);

        $view = new FormView();
        $formInterface = $this->prophesize(FormInterface::class);
        $formInterface->createView()->willReturn($view);

        $this->formBuilder->build(5, 'page', 'tpl', 'en', 'form')
            ->shouldBeCalledOnce()
            ->willReturn($formInterface->reveal());

        $result = $this->extension->getFormByContent(['entity' => $form], 'page', 'tpl');

        $this->assertSame($view, $result);
    }

    public function testGetFormByContentReturnsNullWhenBuilderReturnsNull(): void
    {
        $form = $this->createForm(5, ['en'], 'en');

        $this->formBuilder->build(5, 'page', 'tpl', 'en', 'form')
            ->shouldBeCalledOnce()
            ->willReturn(null);

        $this->assertNull($this->extension->getFormByContent(['entity' => $form], 'page', 'tpl', 'en'));
    }

    /**
     * @param string[] $translationLocales
     */
    private function createForm(int $id, array $translationLocales, string $defaultLocale): Form
    {
        $form = new Form();
        $form->setDefaultLocale($defaultLocale);

        foreach ($translationLocales as $locale) {
            $translation = new FormTranslation();
            $translation->setLocale($locale);
            $translation->setTitle('title-' . $locale);
            $translation->setForm($form);
            $form->addTranslation($translation);
        }

        (new \ReflectionProperty(Form::class, 'id'))->setValue($form, $id);

        return $form;
    }
}
