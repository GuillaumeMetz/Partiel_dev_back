<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(length: 255)]
    private ?string $Content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Post $Post = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $User = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: Like::class)]
    private Collection $countlikes;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: Dislike::class)]
    private Collection $countdislike;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->countlikes = new ArrayCollection();
        $this->countdislike = new ArrayCollection();
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->Post;
    }

    public function setPost(?Post $Post): static
    {
        $this->Post = $Post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
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

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getCountlikes(): Collection
    {
        return $this->countlikes;
    }

    public function addCountlike(Like $countlike): static
    {
        if (!$this->countlikes->contains($countlike)) {
            $this->countlikes->add($countlike);
            $countlike->setComment($this);
        }

        return $this;
    }

    public function removeCountlike(Like $countlike): static
    {
        if ($this->countlikes->removeElement($countlike)) {
            // set the owning side to null (unless already changed)
            if ($countlike->getComment() === $this) {
                $countlike->setComment(null);
            }
        }

        return $this;
    }

    public function getDislike(): ?self
    {
        return $this->Dislike;
    }

    public function setDislike(?self $Dislike): static
    {
        $this->Dislike = $Dislike;

        return $this;
    }

    public function addDislike(self $dislike): static
    {
        if (!$this->dislike->contains($dislike)) {
            $this->dislike->add($dislike);
            $dislike->setDislike($this);
        }

        return $this;
    }

    public function removeDislike(self $dislike): static
    {
        if ($this->dislike->removeElement($dislike)) {
            // set the owning side to null (unless already changed)
            if ($dislike->getDislike() === $this) {
                $dislike->setDislike(null);
            }
        }

        return $this;
    }

    public function getComment(): ?self
    {
        return $this->comment;
    }

    public function setComment(?self $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCountdislike(): Collection
    {
        return $this->countdislike;
    }

    public function addCountdislike(self $countdislike): static
    {
        if (!$this->countdislike->contains($countdislike)) {
            $this->countdislike->add($countdislike);
            $countdislike->setComment($this);
        }

        return $this;
    }

    public function removeCountdislike(self $countdislike): static
    {
        if ($this->countdislike->removeElement($countdislike)) {
            // set the owning side to null (unless already changed)
            if ($countdislike->getComment() === $this) {
                $countdislike->setComment(null);
            }
        }

        return $this;
    }
}
