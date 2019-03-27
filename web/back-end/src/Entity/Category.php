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
     * @ORM\OneToMany(targetEntity="PFMRule", mappedBy="category")
     */
    private $rules;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TagAssociation", mappedBy="category")
     */
    private $tagsAssociations;


    public function __construct()
    {
        $this->rules = new ArrayCollection();
        $this->tagsAssociations = new ArrayCollection();
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
     * @return Collection|PFMRule[]
     */
    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(PFMRule $rule): self
    {
        if (!$this->rules->contains($rule)) {
            $this->rules[] = $rule;
            $rule->setCategory($this);
        }

        return $this;
    }

    public function removeRule(PFMRule $rule): self
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

    public function toJSON() {
        $json['id'] = $this->getId();
        $json['code'] = $this->getCode();
        $json['name'] = $this->getName();
        return $json;
    }

    /**
     * @return Collection|TagAssociation[]
     */
    public function getTagsAssociations(): Collection
    {
        return $this->tagsAssociations;
    }

    public function addTagsAssociation(TagAssociation $tagsAssociation): self
    {
        if (!$this->tagsAssociations->contains($tagsAssociation)) {
            $this->tagsAssociations[] = $tagsAssociation;
            $tagsAssociation->setCategory($this);
        }

        return $this;
    }

    public function removeTagsAssociation(TagAssociation $tagsAssociation): self
    {
        if ($this->tagsAssociations->contains($tagsAssociation)) {
            $this->tagsAssociations->removeElement($tagsAssociation);
            // set the owning side to null (unless already changed)
            if ($tagsAssociation->getCategory() === $this) {
                $tagsAssociation->setCategory(null);
            }
        }

        return $this;
    }
}
