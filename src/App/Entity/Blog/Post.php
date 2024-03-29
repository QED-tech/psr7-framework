<?php

namespace App\Entity\Blog;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;
    /**
     * @ORM\Column(type="datetime_immutable", name="create_date")
     */
    private \DateTimeImmutable $createDate;
    /**
     * @ORM\Column(type="datetime_immutable", name="update_date", nullable=true)
     */
    private \DateTimeImmutable $updateDate;
    /**
     * @ORM\Column(type="string")
     */
    private string $title;
    /**
     * @var Content
     * @ORM\Embedded(class="Content")
     */
    private Content $content;
    /**
     * @var Meta
     * @ORM\Embedded(class="Meta")
     */
    private Meta $meta;
    /**
     * @var ArrayCollection|Comment[]
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $comments;

    #[Pure] public function __construct(\DateTimeImmutable $date, string $title, Content $content, Meta $meta)
    {
        $this->createDate = $date;
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->comments = new ArrayCollection();
    }

    public function edit(string $title, Content $content, Meta $meta): void
    {
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->updateDate = new \DateTimeImmutable();
    }

    public function addComment(\DateTimeImmutable $date, string $author, string $content): void
    {
        $this->comments->add(new Comment($this, $date, $author, $content));
    }

    public function removeComment(int $id): void
    {
        foreach ($this->comments as $comment) {
            if ($comment->getId() === $id) {
                $this->comments->removeElement($comment);
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }

    public function getUpdateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @return Comment[]
     */
    #[Pure] public function getComments(): array
    {
        return $this->comments->toArray();
    }
}
