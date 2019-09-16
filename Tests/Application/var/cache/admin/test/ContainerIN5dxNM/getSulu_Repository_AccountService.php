<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'sulu.repository.account' shared service.

if ($lazyLoad) {
    return $this->services['sulu.repository.account'] = $this->createProxy('AccountRepository_21f7ad1', function () {
        return \AccountRepository_21f7ad1::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
            $wrappedInstance = $this->load('getSulu_Repository_AccountService.php', false);

            $proxy->setProxyInitializer(null);

            return true;
        });
    });
}

$a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

return new \Sulu\Bundle\ContactBundle\Entity\AccountRepository($a, $a->getClassMetadata('Sulu\\Bundle\\ContactBundle\\Entity\\Account'));
