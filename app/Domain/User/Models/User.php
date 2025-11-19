<?php

namespace App\Domain\User\Models;

use App\Domain\Shared\Events\DomainEvent;
use App\Domain\User\Events\UserRegistered;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\PhoneNumber;
use Illuminate\Support\Collection;

class User
{
    private Collection $domainEvents;

    public function __construct(
        private ?int $id,
        private Email $email,
        private string $password,
        private string $role = 'buyer',
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?PhoneNumber $phone = null,
        private ?string $avatar = null,
        private ?\DateTimeImmutable $emailVerifiedAt = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->domainEvents = new Collection();
    }

    public static function create(
        Email $email,
        string $password,
        string $role = 'buyer',
        ?string $firstName = null,
        ?string $lastName = null,
        ?PhoneNumber $phone = null
    ): self {
        $user = new self(
            id: null,
            email: $email,
            password: $password,
            role: $role,
            firstName: $firstName,
            lastName: $lastName,
            phone: $phone,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        $user->recordEvent(new UserRegistered($user));

        return $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return trim(($this->firstName ?? '') . ' ' . ($this->lastName ?? ''));
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    public function verifyEmail(): void
    {
        $this->emailVerifiedAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function updateProfile(
        ?string $firstName = null,
        ?string $lastName = null,
        ?PhoneNumber $phone = null
    ): void {
        if ($firstName !== null) {
            $this->firstName = $firstName;
        }
        if ($lastName !== null) {
            $this->lastName = $lastName;
        }
        if ($phone !== null) {
            $this->phone = $phone;
        }
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function updateAvatar(string $avatarPath): void
    {
        $this->avatar = $avatarPath;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function assignRole(string $role): void
    {
        $this->role = $role;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    protected function recordEvent(DomainEvent $event): void
    {
        $this->domainEvents->push($event);
    }

    public function getDomainEvents(): Collection
    {
        return $this->domainEvents;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = new Collection();
    }
}

