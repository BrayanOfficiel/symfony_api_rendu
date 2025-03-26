<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN') or is_granted('ROLE_DIRECTOR')"),
        new GetCollection(security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN') or is_granted('ROLE_DIRECTOR')"),
        new Post(security: "is_granted('ROLE_ASSISTANT')"),
        new Put(security: "is_granted('ROLE_ASSISTANT') and object.getStatus() != 'terminé'"), // Empeche de modifier un rendez-vous terminé
        new Delete(security: "is_granted('ROLE_DIRECTOR')")
    ]
)]
#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    // Ajout de constantes pour les différents statuts d'un rendez-vous
    public const STATUS_SCHEDULED = 'programmé';
    public const STATUS_IN_PROGRESS = 'en cours';
    public const STATUS_COMPLETED = 'terminé';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $appointmentDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reason = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?User $assistant = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?User $veterinarian = null;

    /**
     * @var Collection<int, Traitement>
     */
    #[ORM\ManyToMany(targetEntity: Traitement::class, inversedBy: 'rendezVouses')]
    private Collection $treatments;

    #[ORM\Column]
    private ?bool $isPaid = null;

    public function __construct()
    {
        $this->treatments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAppointmentDate(): ?\DateTimeInterface
    {
        return $this->appointmentDate;
    }

    public function setAppointmentDate(\DateTimeInterface $appointmentDate): static
    {
        $this->appointmentDate = $appointmentDate;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAssistant(): ?User
    {
        return $this->assistant;
    }

    public function setAssistant(?User $assistant): static
    {
        $this->assistant = $assistant;

        return $this;
    }

    public function getVeterinarian(): ?User
    {
        return $this->veterinarian;
    }

    public function setVeterinarian(?User $veterinarian): static
    {
        $this->veterinarian = $veterinarian;

        return $this;
    }

    /**
     * @return Collection<int, Traitement>
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(Traitement $treatment): static
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments->add($treatment);
        }

        return $this;
    }

    public function removeTreatment(Traitement $treatment): static
    {
        $this->treatments->removeElement($treatment);

        return $this;
    }

    // Vérifie si le rendez-vous peut être assigné à un vétérinaire
    public function canBeAssigned(): bool
    {
        return $this->veterinarian === null && $this->status === self::STATUS_SCHEDULED;
    }

    // Assigner un rendez-vous à un vétérinaire
    public function assignToVeterinarian(User $veterinarian): static
    {
        if ($this->canBeAssigned()) {
            $this->veterinarian = $veterinarian;
        }

        return $this;
    }

    // Mettre à jour le statut du rendez-vous
    public function updateStatus(string $status): static
    {
        if (in_array($status, [self::STATUS_SCHEDULED, self::STATUS_IN_PROGRESS, self::STATUS_COMPLETED])) {
            $this->status = $status;
        }

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): static
    {
        $this->isPaid = $isPaid;

        return $this;
    }
}
