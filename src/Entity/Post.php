<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[Vich\Uploadable]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_de_creation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'name')]
    private Collection $name;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'posts')]
    private Collection $tags;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $auteur = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'Post', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'Post', targetEntity: Like::class)]
    private Collection $countlikes;

    #[ORM\OneToMany(mappedBy: 'Post', targetEntity: Dislike::class)]
    private Collection $countdislike;

    public function __construct()
    {
        $this->name = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->date_de_creation= new \DateTimeImmutable();
        $this->comments = new ArrayCollection();
        $this->countlikes = new ArrayCollection();
        $this->countdislike = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->date_de_creation;
    }

    public function setDateDeCreation(\DateTimeInterface $date_de_creation): static
    {
        $this->date_de_creation = $date_de_creation;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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
            $countlike->setPost($this);
        }

        return $this;
    }

    public function removeCountlike(Like $countlike): static
    {
        if ($this->countlikes->removeElement($countlike)) {
            // set the owning side to null (unless already changed)
            if ($countlike->getPost() === $this) {
                $countlike->setPost(null);
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

    /**
     * @return Collection<int, self>
     */
    public function getName(): Collection
    {
        return $this->name;
    }

    public function addName(self $name): static
    {
        if (!$this->name->contains($name)) {
            $this->name->add($name);
        }

        return $this;
    }

    public function removeName(self $name): static
    {
        $this->name->removeElement($name);

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addPost($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removePost($this);
        }

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

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
            $countdislike->setPost($this);
        }

        return $this;
    }

    public function removeCountdislike(self $countdislike): static
    {
        if ($this->countdislike->removeElement($countdislike)) {
            // set the owning side to null (unless already changed)
            if ($countdislike->getPost() === $this) {
                $countdislike->setPost(null);
            }
        }

        return $this;
    }
}