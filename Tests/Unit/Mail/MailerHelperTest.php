<?php


namespace Sulu\Bundle\FormBundle\Tests\Unit\Mail;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Sulu\Bundle\FormBundle\Mail\MailerHelper;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

/**
 * Class MailerHelperTest
 * This tests the MailerHelper class that sends an email using the symfony mailer component.
 *
 * The MailerHelper class has 3 protected methods that could be overwritten to change the mail message.
 * The setHeaders must set the headers of the email including to cc bcc ect.
 * The setBody must set the html or text body of the email.
 * The setAttachments should set attachments to the email.
 * The setAttachments should set attachments to the email.
 * in the future it might be nice to delegate the methods to a separate service.
 *
 * @package Sulu\Bundle\FormBundle\Tests\Unit\Mail
 */
class MailerHelperTest extends TestCase
{
    /**
     * @var MailerHelper
     */
    private $mailerHelper;

    /**
     * @var MockObject|MailerInterface
     */
    private $mailerMock;

    /**
     * @var MockObject|LoggerInterface
     */
    private $loggerMock;

    protected function setUp(): void
    {
        $this->mailerMock = $this->getMockBuilder(MailerInterface::class)->getMock();
        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)->getMock();

        $this->mailerHelper = new MailerHelper(
            $this->mailerMock,
            'from@example.org',
            'to@example.org',
            'sender@example.org',
            $this->loggerMock
        );
    }

    /**
     * Ensure that the setup actually constructed the mail helper.
     *
     * This is useful when the constructor signature changes and this test fails
     */
    public function testConstructs()
    {
        $this->assertNotNull($this->mailerHelper);
    }

    /**
     * Send the most Basic mail, just a html text with a subject.
     *
     * This should send a html message to the addresses given in the constructor.
     */
    public function testSendMailSendsMinimalMessageWithConstructorAdresses()
    {
        $mail = new Email();
        $mail->html('<html><head></head><body>text body</body></html>')
            ->subject('test subject')
            ->to('to@example.org')
            ->from('from@example.org')
            ->sender('sender@example.org');

        $this->mailerMock->expects($this->once())
            ->method('send')
            ->with($this->equalTo($mail));

        $this->loggerMock->expects($this->once())
            ->method('info')
            ->with($this->equalTo(sprintf(
                'Try register mail from SuluFormBundle: ' . PHP_EOL .
                '   From: from@example.org' . PHP_EOL .
                '   To: to@example.org' . PHP_EOL .
                '   Reply to: %s' . PHP_EOL .
                '   Subject: test subject' . PHP_EOL .
                '   CC: %s' . PHP_EOL .
                '   BCC: %s' . PHP_EOL .
                '   Plain text: %s' . PHP_EOL,
                serialize(null),
                serialize([]),
                serialize([]),
                null
            )));

        $this->mailerHelper->sendMail(
            'test subject',
            '<html><head></head><body>text body</body></html>'
        );
    }

    /**
     * Send mail to addresses and from an address, just plain text.
     */
    public function testSendMailSendsWithPlainTextAndNamedAddresses()
    {
        $mail = new Email();
        $mail->text('plain text body.')
            ->subject('test subject')
            ->to(new Address('to@example.org', 'To Email'))
            ->from(new Address('from@example.org', 'From Email'))
            ->sender('sender@example.org');

        $this->mailerMock->expects($this->once())
            ->method('send')
            ->with($this->equalTo($mail));

        $this->mailerHelper->sendMail(
            'test subject',
            'plain text body.',
            ['to@example.org' => 'To Email'],
            ['from@example.org' => 'From Email'],
            false
        );
    }

    /**
     * Sends mail with attachment
     *
     * Normal files should have filesystem names
     * Uploaded Files should have the original filename
     */
    public function testSendMailSendsMailWithAttachments()
    {
        $mail = new Email();
        $mail->html('<h1>html text body.</h1>')
            ->subject('test subject')
            ->to('to@example.org')
            ->from('from@example.org')
            ->sender('sender@example.org')
            ->attachFromPath(__FILE__, basename(__FILE__))
            ->attachFromPath(__FILE__, basename('example.php'))
        ;

        $this->mailerMock->expects($this->once())
            ->method('send')
            ->with($this->equalTo($mail));

        $this->mailerHelper->sendMail(
            'test subject',
            '<h1>html text body.</h1>',
            null,
            null,
            true,
            [],
            [
                new File(__FILE__),
                new UploadedFile(__FILE__, 'example.php')
            ]
        );
    }

    /**
     * Send mail with all parameters, named email adresses but not with attachments
     *
     * custom text should be used
     * html message should be used.
     * multiple cc's can be set.
     */
    public function testSendMailSendsMailWithoutAttachments()
    {
        $mail = new Email();
        $mail->html('<h1>html text body.</h1>')
            ->text('test message in plain text')
            ->subject('test subject')
            ->to(new Address('to@example.org', 'To Email'))
            ->from(new Address('from@example.org', 'From Email'))
            ->sender('sender@example.org')
            ->cc(
                new Address('cc@example.org', 'CC Email'),
                new Address('cc2@example.org', 'CC2 Email')
            )
            ->bcc(new Address('bcc@example.org', 'bCC Email'))
            ->replyTo(new Address('reply-to@example.org', 'ReplyTo Email'))
            ;

        $this->mailerMock->expects($this->once())
            ->method('send')
            ->with($this->equalTo($mail));

        $this->mailerHelper->sendMail(
            'test subject',
            '<h1>html text body.</h1>',
            ['to@example.org' => 'To Email'],
            ['from@example.org' => 'From Email'],
            true,
            ['reply-to@example.org' => 'ReplyTo Email'],
            [],
            [
                'cc@example.org' => 'CC Email',
                'cc2@example.org' => 'CC2 Email',
            ],
            ['bcc@example.org' => 'bCC Email'],
            'test message in plain text'
        );
    }

}
