<?php


namespace Sulu\Bundle\FormBundle\Tests\Application;


use Symfony\Component\Config\Loader\LoaderInterface;

class MailerKernel extends Kernel
{
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        parent::registerContainerConfiguration($loader);

        $loader->load(__DIR__ . '/config/config_test_mailer.yaml');
    }

    public function getCacheDir()
    {
        return $this->getProjectDir() . \DIRECTORY_SEPARATOR
            . 'var' . \DIRECTORY_SEPARATOR
            . 'cache' . \DIRECTORY_SEPARATOR
            . $this->getContext()  . \DIRECTORY_SEPARATOR
            . $this->environment;
    }
}
