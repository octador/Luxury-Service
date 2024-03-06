<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'experience')]
    private Collection $candidats;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): static
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats->add($candidat);
            $candidat->setExperience($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): static
    {
        if ($this->candidats->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getExperience() === $this) {
                $candidat->setExperience(null);
            }
        }

        return $this;
    }
}
