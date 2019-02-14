<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NounTypeRepository")
 */
class NounType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    /**
     * @ORM\Column(type="boolean")
     */
    private $number;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Word", inversedBy="grammar", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idWord;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getNumber(): ?bool
    {
        return $this->number;
    }

    public function setNumber(bool $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getIdWord(): ?Word
    {
        return $this->idWord;
    }

    public function setIdWord(Word $idWord): self
    {
        $this->idWord = $idWord;

        return $this;
    }
}
