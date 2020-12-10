<?php

namespace Prescreen\ApiResourceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ExampleEntity
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
     * @var bool
     */
    private $isCool = true;
    /**
     * @var Collection
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

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
     * @return ExampleEntity
     */
    public function setId(int $id): ExampleEntity
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
     * @return ExampleEntity
     */
    public function setName(string $name): ExampleEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCool(): bool
    {
        return $this->isCool;
    }

    /**
     * @param bool $isCool
     *
     * @return ExampleEntity
     */
    public function setIsCool(bool $isCool): ExampleEntity
    {
        $this->isCool = $isCool;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getTranslations(): ?Collection
    {
        return $this->translations;
    }

    /**
     * @param Collection $translations
     *
     * @return ExampleEntity
     */
    public function setTranslations(Collection $translations): ExampleEntity
    {
        $this->translations = $translations;
        return $this;
    }

    /**
     * @param ExampleTranslationEntity $translation
     *
     * @return $this
     */
    public function addTranslation(ExampleTranslationEntity $translation): ExampleEntity
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * @param ExampleTranslationEntity $translation
     *
     * @return $this
     */
    public function removeTranslation(ExampleTranslationEntity $translation): ExampleEntity
    {
        $this->translations->removeElement($translation);

        return $this;
    }
}
