<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $bank;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $account_number;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity=Income::class, mappedBy="account")
     */
    private $incomes;

    /**
     * @ORM\OneToMany(targetEntity=Outcome::class, mappedBy="account")
     */
    private $outcomes;

    public function __construct()
    {
        $this->incomes = new ArrayCollection();
        $this->outcomes = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->account_number;
    }

    public function setAccountNumber(?string $account_number): self
    {
        $this->account_number = $account_number;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection|Income[]
     */
    public function getIncomes(): Collection
    {
        return $this->incomes;
    }

    public function addIncome(Income $income): self
    {
        if (!$this->incomes->contains($income)) {
            $this->incomes[] = $income;
            $income->setAccount($this);
        }

        return $this;
    }

    public function removeIncome(Income $income): self
    {
        if ($this->incomes->contains($income)) {
            $this->incomes->removeElement($income);
            // set the owning side to null (unless already changed)
            if ($income->getAccount() === $this) {
                $income->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Outcome[]
     */
    public function getOutcomes(): Collection
    {
        return $this->outcomes;
    }

    public function addOutcome(Outcome $outcome): self
    {
        if (!$this->outcomes->contains($outcome)) {
            $this->outcomes[] = $outcome;
            $outcome->setAccount($this);
        }

        return $this;
    }

    public function removeOutcome(Outcome $outcome): self
    {
        if ($this->outcomes->contains($outcome)) {
            $this->outcomes->removeElement($outcome);
            // set the owning side to null (unless already changed)
            if ($outcome->getAccount() === $this) {
                $outcome->setAccount(null);
            }
        }

        return $this;
    }
}
