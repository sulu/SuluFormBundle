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

namespace Sulu\Bundle\FormBundle\Tests\SpamChecker;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\FormBundle\Configuration\FormConfigurationInterface;
use Sulu\Bundle\FormBundle\Exception\FormSubmissionIsSpamException;
use Sulu\Bundle\FormBundle\SpamChecker\SpamChecker;
use Sulu\Bundle\FormBundle\SpamChecker\SpamCheckerInterface;
use Symfony\Component\Form\FormInterface;

class SpamCheckerTest extends TestCase
{
    /**
     * @var SpamChecker
     */
    private $spamChecker;

    public function setUp(): void
    {
        $spamChecker1 = $this->prophesize(SpamCheckerInterface::class);
        $spamChecker1->check(Argument::any(), Argument::any())->willThrow(
            new FormSubmissionIsSpamException(SpamCheckerInterface::SPAM_STRATEGY_SPAM, 'spamChecker1')
        );

        $spamChecker2 = $this->prophesize(SpamCheckerInterface::class);
        $spamChecker2->check(Argument::any(), Argument::any())->willThrow(
            new FormSubmissionIsSpamException(SpamCheckerInterface::SPAM_STRATEGY_NO_SAVE, 'spamChecker2')
        );

        $spamChecker3 = $this->prophesize(SpamCheckerInterface::class);
        $spamChecker3->check(Argument::any(), Argument::any())->willThrow(
            new FormSubmissionIsSpamException(SpamCheckerInterface::SPAM_STRATEGY_NO_EMAIL, 'spamChecker3')
        );

        $spamChecker4 = $this->prophesize(SpamCheckerInterface::class);
        $spamChecker4->check(Argument::any(), Argument::any())->willThrow(
            new FormSubmissionIsSpamException(SpamCheckerInterface::SPAM_STRATEGY_NO_SAVE, 'spamChecker4')
        );

        $this->spamChecker = new SpamChecker([
            $spamChecker1->reveal(),
            $spamChecker2->reveal(),
            $spamChecker3->reveal(),
            $spamChecker4->reveal(),
        ]);
    }

    public function testCheck(): void
    {
        $this->expectExceptionObject(
            new FormSubmissionIsSpamException(SpamCheckerInterface::SPAM_STRATEGY_NO_SAVE, 'spamChecker2')
        );

        $form = $this->prophesize(FormInterface::class);
        $formConfiguration = $this->prophesize(FormConfigurationInterface::class);

        $this->spamChecker->check($form->reveal(), $formConfiguration->reveal());
    }
}
