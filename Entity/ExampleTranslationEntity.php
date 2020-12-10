<?php

namespace Prescreen\ApiResourceBundle\Entity;

class ExampleTranslationEntity
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $locale;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ExampleTranslationEntity
     */
    public function setId(int $id): ExampleTranslationEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ExampleTranslationEntity
     */
    public function setName(string $name): ExampleTranslationEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return ExampleTranslationEntity
     */
    public function setLocale(string $locale): ExampleTranslationEntity
    {
        $this->locale = $locale;
        return $this;
    }
}
