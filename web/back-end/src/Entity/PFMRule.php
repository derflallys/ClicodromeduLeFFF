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
     * @ORM\Column(type="string", length=255)
     */
    private $rule;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="rules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

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

    public function getRule(): ?string
    {
        return $this->rule;
    }

    public function setRule(string $rule): self
    {
        $this->rule = $rule;

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
}
