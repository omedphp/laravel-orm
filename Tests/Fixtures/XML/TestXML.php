<?php


namespace Omed\Laravel\ORM\Tests\Fixtures\XML;


class TestXML
{
    /**
     * @var string
     */
    protected $id;

    /**
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
     * @return TestXML
     */
    public function setId(string $id): TestXML
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
     * @return TestXML
     */
    public function setName(string $name): TestXML
    {
        $this->name = $name;
        return $this;
    }
}