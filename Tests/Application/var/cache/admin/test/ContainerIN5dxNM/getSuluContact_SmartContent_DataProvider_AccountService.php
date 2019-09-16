<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_contact.smart_content.data_provider.account' shared service.

return $this->privates['sulu_contact.smart_content.data_provider.account'] = new \Sulu\Component\Contact\SmartContent\AccountDataProvider(($this->services['sulu_contact.account_manager'] ?? $this->load('getSuluContact_AccountManagerService.php')), ($this->services['jms_serializer'] ?? $this->getJmsSerializerService()), ($this->privates['sulu_contact.reference_store.account'] ?? ($this->privates['sulu_contact.reference_store.account'] = new \Sulu\Bundle\WebsiteBundle\ReferenceStore\ReferenceStore())));
