<?php


namespace Omed\Laravel\ORM\Tests\Fixtures\Model;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class TestAnnotation
 *
 * @ORM\Entity()
 * @package Omed\Laravel\ORM\Tests\Fixtures\Model
 */
class TestAnnotation
{
    /**
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Id()
     * @var string
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return TestAnnotation
     */
    public function setId(string $id): TestAnnotation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TestAnnotation
     */
    public function setName(string $name): TestAnnotation
    {
        $this->name = $name;
        return $this;
    }
}