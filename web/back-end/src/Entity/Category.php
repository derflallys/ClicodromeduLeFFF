<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PFMRules", mappedBy="category")
     */
    private $rules;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TagCategory", mappedBy="category")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->rules = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection|PFMRules[]
     */
    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(PFMRules $rule): self
    {
        if (!$this->rules->contains($rule)) {
            $this->rules[] = $rule;
            $rule->setCategory($this);
        }

        return $this;
    }

    public function removeRule(PFMRules $rule): self
    {
        if ($this->rules->contains($rule)) {
            $this->rules->removeElement($rule);
            // set the owning side to null (unless already changed)
            if ($rule->getCategory() === $this) {
                $rule->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TagCategory[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(TagCategory $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setCategory($this);
        }

        return $this;
    }

    public function removeTag(TagCategory $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            // set the owning side to null (unless already changed)
            if ($tag->getCategory() === $this) {
                $tag->setCategory(null);
            }
        }

        return $this;
    }

    public function toJSON() {
        $json['id'] = $this->getId();
        $json['code'] = $this->getCode();
        $json['name'] = $this->getName();
        return $json;
    }
}
