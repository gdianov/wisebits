<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\DirtyWords;
use App\Validator\InvalidEmailDomain;
use JMS\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
#[UniqueEntity("name")]
#[UniqueEntity("email")]
#[Serializer\ExclusionPolicy("none")]
#[Serializer\AccessType(type: "public_method")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Serializer\SerializedName("id")]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Assert\Regex('/^[a-z0-9]+$/i')]
    #[Assert\Length(min: 8)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[DirtyWords]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[InvalidEmailDomain]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Serializer\Type("DateTime<'Y-m-d H:i:s'>")]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Serializer\Type("DateTime<'Y-m-d H:i:s'>")]
    #[Assert\Expression(expression: "this.getDeleted() ? this.getDeleted() > this.getCreated() : true")]
    private ?\DateTimeInterface $deleted = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getDeleted(): ?\DateTimeInterface
    {
        return $this->deleted;
    }

    public function setDeleted(?\DateTimeInterface $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }
}
