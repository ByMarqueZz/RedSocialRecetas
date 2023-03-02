<?php

namespace App\Entity;

use App\Repository\RecetaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetaRepository::class)]
class Receta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo_receta = null;

    #[ORM\ManyToOne(inversedBy: 'recetas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_usuario = null;

    #[ORM\ManyToMany(targetEntity: Ingrediente::class, inversedBy: 'recetas')]
    private Collection $id_ingrediente;

    #[ORM\OneToMany(mappedBy: 'receta', targetEntity: Foto::class)]
    private Collection $id_foto;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    public function __construct()
    {
        $this->id_ingrediente = new ArrayCollection();
        $this->id_foto = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTipoReceta(): ?string
    {
        return $this->tipo_receta;
    }

    public function setTipoReceta(string $tipo_receta): self
    {
        $this->tipo_receta = $tipo_receta;

        return $this;
    }

    public function getIdUsuario(): ?Usuario
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?Usuario $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * @return Collection<int, Ingrediente>
     */
    public function getIdIngrediente(): Collection
    {
        return $this->id_ingrediente;
    }

    public function addIdIngrediente(Ingrediente $idIngrediente): self
    {
        if (!$this->id_ingrediente->contains($idIngrediente)) {
            $this->id_ingrediente->add($idIngrediente);
        }

        return $this;
    }

    public function removeIdIngrediente(Ingrediente $idIngrediente): self
    {
        $this->id_ingrediente->removeElement($idIngrediente);

        return $this;
    }

    /**
     * @return Collection<int, Foto>
     */
    public function getIdFoto(): Collection
    {
        return $this->id_foto;
    }

    public function addIdFoto(Foto $idFoto): self
    {
        if (!$this->id_foto->contains($idFoto)) {
            $this->id_foto->add($idFoto);
            $idFoto->setReceta($this);
        }

        return $this;
    }

    public function removeIdFoto(Foto $idFoto): self
    {
        if ($this->id_foto->removeElement($idFoto)) {
            // set the owning side to null (unless already changed)
            if ($idFoto->getReceta() === $this) {
                $idFoto->setReceta(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
