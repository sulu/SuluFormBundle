<?php

namespace Sulu\Bundle\FormBundle\Tests\Functional\Dynamic;

use Sulu\Bundle\TestBundle\Testing\SuluTestCase;



class FormFieldTypeProviderTest extends SuluTestCase
{

    private $formFieldTypeProvider;

    
    protected function setUp()
    {
        $this->formFieldTypeProvider = $this->getContainer()->get('sulu_form.metadata.form_field_type_provider');
    }
    
    public function testLoadFieldTypes() {
        $formMetadata = $this->formFieldTypeProvider->loadFieldTypes();
        //var_dump($formMetadata);
        $this->assertNotNull($formMetadata);
    }
}
