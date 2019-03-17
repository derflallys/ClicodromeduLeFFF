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
     * @ORM\Column(type="text", nullable=true)
     */
    private $tags;

    private $inflectedForms;

    public function __construct()
    {
        $this->inflectedForms = new ArrayCollection();
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

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getInflectedForms(): Collection
    {
        return $this->inflectedForms;
    }

    public function addInflectedForm(string $form): self
    {
        if (!$this->inflectedForms->contains($form)) {
            $this->inflectedForms[] = $form;
        }
        return $this;
    }

    public function removeInflectedForm(string $form): self
    {
        if ($this->inflectedForms->contains($form)) {
            $this->inflectedForms->removeElement($form);
        }
        return $this;
    }

    public function setInflectedForms($forms): self
    {
        $this->inflectedForms = $forms;
        return $this;
    }

    public function toJSON() {
        $json['id'] = $this->id;
        $json['value'] = $this->value;
        $json['category'] = $this->category->toJSON();
        $json['tags'] = $this->tags;
        $json['inflectedForms'] = $this->inflectedForms;
        return $json;
    }
}
