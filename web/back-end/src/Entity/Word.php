<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 */
class Word
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NounType", mappedBy="word", cascade={"persist", "remove"})
     */
    private $grammar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getGrammar(): ?NounType
    {
        return $this->grammar;
    }

    public function setGrammar(NounType $grammar): self
    {
        $this->grammar = $grammar;

        // set the owning side of the relation if necessary
        if ($this !== $grammar->getWord()) {
            $grammar->setWord($this);
        }

        return $this;
    }

    public function toJSON() {
        $json['id'] = $this->id;
        $json['value'] = $this->value;
        $json['category'] = $this->category->toJSON();
        return $json;
    }
}
