<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity="App\Entity\TagWord", mappedBy="word")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }


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

    /**
     * @return Collection|TagWord[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(TagWord $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setWord($this);
        }

        return $this;
    }

    public function removeTag(TagWord $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            // set the owning side to null (unless already changed)
            if ($tag->getWord() === $this) {
                $tag->setWord(null);
            }
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
