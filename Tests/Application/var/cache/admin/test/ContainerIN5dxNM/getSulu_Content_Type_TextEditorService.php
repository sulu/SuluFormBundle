<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'sulu.content.type.text_editor' shared service.

return $this->services['sulu.content.type.text_editor'] = new \Sulu\Component\Content\Types\TextEditor(($this->privates['sulu_markup.parser'] ?? $this->getSuluMarkup_ParserService()));
