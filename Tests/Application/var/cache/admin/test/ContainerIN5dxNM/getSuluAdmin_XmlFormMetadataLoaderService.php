<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_admin.xml_form_metadata_loader' shared service.

return $this->privates['sulu_admin.xml_form_metadata_loader'] = new \Sulu\Bundle\AdminBundle\Metadata\FormMetadata\XmlFormMetadataLoader(($this->privates['sulu_admin.form_metadata.form_xml_loader'] ?? $this->load('getSuluAdmin_FormMetadata_FormXmlLoaderService.php')), $this->parameters['sulu_admin.forms.directories'], ($this->targetDirs[0].'/sulu/forms'), true);
