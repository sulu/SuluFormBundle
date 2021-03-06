<?php


namespace Sulu\Bundle\FormBundle\Mail;


class HelperAwareConfigurator
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var HelperInterface
     */
    private $helper;

    public function __construct(HelperInterface $helperDefault, iterable $helpers, string $name)
    {
        $this->helper = $helperDefault;

        $helperArray = iterator_to_array($helpers);
        if (isset($helperArray[$name])) {
            $this->helper = $helperArray[$name];
        }
    }

    public function __invoke(HelperAwareInterface $helperAware)
    {
        $helperAware->setHelper($this->helper);
    }
}
