<?php

namespace Prescreen\ApiResourceBundle\src\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ExampleEntity
{
    private ?int $id = null;
    private ?string $name = null;
    private bool $isCool = true;
    private Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function isCool(): bool
    {
        return $this->isCool;
    }

    public function setIsCool(bool $isCool): static
    {
        $this->isCool = $isCool;
        return $this;
    }

    public function getTranslations(): ?Collection
    {
        return $this->translations;
    }

    public function setTranslations(Collection $translations): static
    {
        $this->translations = $translations;
        return $this;
    }

    public function addTranslation(ExampleTranslationEntity $translation): static
    {
        $this->translations[] = $translation;

        return $this;
    }

    public function removeTranslation(ExampleTranslationEntity $translation): static
    {
        $this->translations->removeElement($translation);

        return $this;
    }
}
