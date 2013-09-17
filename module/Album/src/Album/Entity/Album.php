<?php
/**
 *
 */
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * A music album.
 *

 * @ORM\Entity
 * @ORM\Table(name="album")
 * @property string $artist
 * @property string $title
 * @property int $id
 *
 * @Annotation\Name("album")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 */
class Album  // implements InputFilterAwareInterface
{
   // protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Annotation\Exclude()
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Annotation\Name("artist")
     * @Annotation\Required(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"encoding":"UTF-8","min":1,"max":100}})
     */
    public $artist;

    /**
     * @ORM\Column(type="string")
     *
     * @Annotation\Name("title")
     * @Annotation\Required(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"encoding":"UTF-8","min":1,"max":100}})
     *
     */
    public $title;

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->artist = (isset($data['artist'])) ? $data['artist'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
    }
}