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
    private $idCategory;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NounType", mappedBy="idWord", cascade={"persist", "remove"})
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

    public function getIdCategory(): ?Category
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Category $idCategory): self
    {
        $this->idCategory = $idCategory;

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
        if ($this !== $grammar->getIdWord()) {
            $grammar->setIdWord($this);
        }

        return $this;
    }
}
