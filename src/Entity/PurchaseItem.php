<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PurchaseItemRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"purchase_item:read"}},
 *     denormalizationContext={"groups"={"purchase_item:write"}}
 * )
 */
class PurchaseItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Purchase::class, inversedBy="purchaseItems")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase_item:read", "purchase_item:write"})
     */
    private ?Purchase $purchase;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase_item:read", "purchase_item:write", "purchase:write"})
     */
    private ?Product $product;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class)
     * @Groups({"purchase_item:read", "purchase_item:write", "purchase:write"})
     */
    private ?Color $color;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"purchase_item:read", "purchase_item:write", "purchase:write"})
     */
    private ?int $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
