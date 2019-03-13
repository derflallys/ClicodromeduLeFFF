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
    private $combinattion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tagsAssociations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCombinattion(): ?string
    {
        return $this->combinattion;
    }

    public function setCombinattion(string $combinattion): self
    {
        $this->combinattion = $combinattion;

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
