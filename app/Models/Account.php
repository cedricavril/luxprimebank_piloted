<?php

class Account
{
    // ✅ Identifiant technique (sera utile plus tard en BDD)
    private int $id_compte;

    // ✅ Numéro de compte métier
    // - UNIQUE
    // - STRING (zéros autorisés)
    // - EXACTEMENT 11 chiffres
    private string $num_compte;

    // ✅ OFFSHORE | OFFSHORE_PLUS
    private string $type;

    // ✅ IBAN (sera automatisé à l'étape 3)
    private string $iban;

    // ✅ Solde JAMAIS négatif
    private float $solde;

    // ✅ Status modifié UNIQUEMENT via ADMIN (plus tard)
    private string $status;

    /**
     * Constructeur métier minimal
     * (On garde un fonctionnement compatible avec le dashboard actuel)
     */
    public function __construct(
        int $id_compte = 1,
        string $num_compte = '00000000001',
        string $type = 'OFFSHORE',
        string $iban = 'LU89 0061 1014 0372 1090',
        float $solde = 1250.50,
        string $status = 'ACTIVE'
    ) {
        $this->id_compte  = $id_compte;
        // ✅ Validation stricte du numéro de compte (11 chiffres, string)
        if (!preg_match('/^\d{11}$/', $num_compte)) {
            throw new InvalidArgumentException(
                'num_compte must be a string of exactly 11 digits'
            );
        }

        $this->num_compte = $num_compte;
        // Validate account type
        if (!in_array($type, ['OFFSHORE', 'OFFSHORE_PLUS'], true)) {
            throw new InvalidArgumentException('Invalid account type');
        }

        $this->type = $type;

        // Automatically generate IBAN based on account type
        if ($type === 'OFFSHORE') {
            $this->iban = 'LU89 0061 1014 0372 1090';
        } else {
            $this->iban = 'LU89 0061 1014 0372 1092';
        }
        $this->solde      = $solde;
        $this->status     = $status;
    }

    // =========================
    // ✅ GETTERS (propres)
    // =========================

    public function getId(): int
    {
        return $this->id_compte;
    }

    public function getNumCompte(): string
    {
        return $this->num_compte;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getBalance(): float
    {
        return $this->solde;
    }

    // =========================
    // ✅ RÈGLE MÉTIER CRITIQUE
    // =========================

    /**
     * Applique une opération au solde
     * ✅ INTERDICTION ABSOLUE DU SOLDE NÉGATIF
     */
    public function applyOperation(float $amount): bool
    {
        $newBalance = $this->solde + $amount;

        // ✅ Protection bancaire stricte
        if ($newBalance < 0) {
            return false;
        }

        $this->solde = $newBalance;
        return true;
    }
    /**
     * Change account status (ADMIN only)
     */
    public function setStatus(string $status, string $role): void
    {
        // Only ADMIN is allowed to change account status
        if ($role !== 'ADMIN') {
            throw new InvalidArgumentException('Only ADMIN can change account status');
        }

        // Validate allowed statuses
        if (!in_array($status, ['ACTIVE', 'BLOCKED'], true)) {
            throw new InvalidArgumentException('Invalid account status');
        }

        $this->status = $status;
    }
}
