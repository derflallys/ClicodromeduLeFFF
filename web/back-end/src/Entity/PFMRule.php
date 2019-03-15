<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PFMRulesRepository")
 */
class PFMRule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $applicationLevel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="rules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tagWord;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tagCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplicationLevel(): ?int
    {
        return $this->applicationLevel;
    }

    public function setApplicationLevel(int $applicationLevel): self
    {
        $this->applicationLevel = $applicationLevel;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTagWord(): ?string
    {
        return $this->tagWord;
    }

    public function setTagWord(?string $tagWord): self
    {
        $this->tagWord = $tagWord;

        return $this;
    }

    public function getTagCategory(): ?string
    {
        return $this->tagCategory;
    }

    public function setTagCategory(?string $tagCategory): self
    {
        $this->tagCategory = $tagCategory;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function __toString()
    {
        return "{" . $this->getApplicationLevel() . "},{" . $this->getTagWord() . "},{" . $this->getTagCategory() . "}=>" . $this->getResult();
    }
}
