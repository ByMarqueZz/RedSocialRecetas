<?php

namespace App\Entity;

use App\Repository\IngredienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredienteRepository::class)]
class Ingrediente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ingrediente = null;

    #[ORM\ManyToMany(targetEntity: Receta::class, mappedBy: 'id_ingrediente')]
    private Collection $recetas;

    public function __construct()
    {
        $this->recetas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngrediente(): ?string
    {
        return $this->ingrediente;
    }

    public function setIngrediente(string $ingrediente): self
    {
        $this->ingrediente = $ingrediente;

        return $this;
    }

    /**
     * @return Collection<int, Receta>
     */
    public function getRecetas(): Collection
    {
        return $this->recetas;
    }

    public function addReceta(Receta $receta): self
    {
        if (!$this->recetas->contains($receta)) {
            $this->recetas->add($receta);
            $receta->addIdIngrediente($this);
        }

        return $this;
    }

    public function removeReceta(Receta $receta): self
    {
        if ($this->recetas->removeElement($receta)) {
            $receta->removeIdIngrediente($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->ingrediente;
    }
}
