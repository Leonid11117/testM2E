<?php

namespace App\DTO\UploadFile;

class UploadFileItem
{
    private ?int $id = null;

    public function __construct(
        private string $idFile,
        private string $purchaseDate,
        private string $shipToName,
        private string $customerEmail,
        private int $grantTotal,
        private string $status,
        private string $createdAt,
        private string $updatedAt,
    ) {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdFile(): string
    {
        return $this->idFile;
    }

    /**
     * @param string $idFile
     */
    public function setIdFile(string $idFile): void
    {
        $this->idFile = $idFile;
    }

    /**
     * @return string
     */
    public function getPurchaseDate(): string
    {
        return $this->purchaseDate;
    }

    /**
     * @return string
     */
    public function getShipToName(): string
    {
        return $this->shipToName;
    }

    /**
     * @return string
     */
    public function getCustomerEmail(): string
    {
        return $this->customerEmail;
    }

    /**
     * @return int
     */
    public function getGrantTotal(): int
    {
        return $this->grantTotal;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
