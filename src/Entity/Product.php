<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private array $image = [];

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\Column]
    private array $categoryImage = [];

    #[ORM\Column]
    private ?bool $isNew = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Item>
     */
    #[JoinTable(name: 'product_items')]
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'products')]
    private Collection $includes;

    #[ORM\Column]
    private array $gallery = [];

    /**
     * @var Collection<int, self>
     */
    #[JoinTable(name: 'product_others')]
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'products')]
    private Collection $others;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'others')]
    private Collection $products;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $feature = null;

    #[ORM\Column]
    private array $sharedImage = [];

    public function __construct()
    {
        $this->includes = new ArrayCollection();
        $this->others = new ArrayCollection();
        $this->products = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): array
    {
        return $this->image;
    }

    public function setImage(array $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCategoryImage(): array
    {
        return $this->categoryImage;
    }

    public function setCategoryImage(array $categoryImage): static
    {
        $this->categoryImage = $categoryImage;

        return $this;
    }

    public function isNew(): ?bool
    {
        return $this->isNew;
    }

    public function setNew(bool $isNew): static
    {
        $this->isNew = $isNew;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getIncludes(): Collection
    {
        return $this->includes;
    }

    public function addInclude(Item $include): static
    {
        if (!$this->includes->contains($include)) {
            $this->includes->add($include);
        }

        return $this;
    }

    public function removeInclude(Item $include): static
    {
        $this->includes->removeElement($include);

        return $this;
    }

    public function getGallery(): array
    {
        return $this->gallery;
    }

    public function setGallery(array $gallery): static
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getOthers(): Collection
    {
        return $this->others;
    }

    public function addOther(self $other): static
    {
        if (!$this->others->contains($other)) {
            $this->others->add($other);
        }

        return $this;
    }

    public function removeOther(self $other): static
    {
        $this->others->removeElement($other);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(self $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addOther($this);
        }

        return $this;
    }

    public function removeProduct(self $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeOther($this);
        }

        return $this;
    }

    public function getFeature(): ?string
    {
        return $this->feature;
    }

    public function setFeature(string $feature): static
    {
        $this->feature = $feature;

        return $this;
    }

    public function getSharedImage(): array
    {
        return $this->sharedImage;
    }

    public function setSharedImage(array $sharedImage): static
    {
        $this->sharedImage = $sharedImage;

        return $this;
    }
}
