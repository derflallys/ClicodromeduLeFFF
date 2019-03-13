<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagWordRepository")
 */
class TagWord
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keyTag;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valueTag;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Word", inversedBy="tags")
     */
    private $word;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyTag(): ?string
    {
        return $this->keyTag;
    }

    public function setKeyTag(?string $keyTag): self
    {
        $this->keyTag = $keyTag;

        return $this;
    }

    public function getValueTag(): ?string
    {
        return $this->valueTag;
    }

    public function setValueTag(string $valueTag): self
    {
        $this->valueTag = $valueTag;

        return $this;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): self
    {
        $this->word = $word;

        return $this;
    }
}
