<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagAssociationRepository")
 */
class TagAssociation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $combination;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tagsAssociations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCombination(): ?string
    {
        return $this->combination;
    }

    public function setCombination(string $combination): self
    {
        $this->combination = $combination;

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

    public function __toString()
    {
        return $this->combination;
    }
}
