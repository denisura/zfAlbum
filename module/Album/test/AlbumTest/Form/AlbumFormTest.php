<?php
namespace AlbumTest\Form;
use Album\Form\AlbumForm;

class AlbumFormTest extends \PHPUnit_Framework_TestCase {
    /**
     * Ensure form has elements
     */
    public function testConstruct()
    {
        $form = new AlbumForm();
        $elements = $form->getElements();
        $this->assertNotEmpty($elements);
    }
}
