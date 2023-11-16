<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tag = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $imageName = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'quacks')]
    private ?self $quackComment = null;

    #[ORM\OneToMany(mappedBy: 'quackComment', targetEntity: self::class)]
    private Collection $quacks;


    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->quacks = new ArrayCollection();
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;


        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getQuackComment(): ?self
    {
        return $this->quackComment;
    }

    public function setQuackComment(?self $quackComment): static
    {
        $this->quackComment = $quackComment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getQuacks(): Collection
    {
        return $this->quacks;
    }

    public function addQuack(self $quack): static
    {
        if (!$this->quacks->contains($quack)) {
            $this->quacks->add($quack);
            $quack->setQuackComment($this);
        }

        return $this;
    }

    public function removeQuack(self $quack): static
    {
        if ($this->quacks->removeElement($quack)) {
            // set the owning side to null (unless already changed)
            if ($quack->getQuackComment() === $this) {
                $quack->setQuackComment(null);
            }
        }

        return $this;
    }

}