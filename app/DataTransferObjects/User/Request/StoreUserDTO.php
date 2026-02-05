<?php

namespace App\DataTransferObjects\User\Request;

class StoreUserDTO
{
    /**
     * Data Transfer Object for storing a new user.
     *
     * @param string $name     The user's name.
     * @param string $email    The user's email address.
     * @param string $password The user's password.
     * @param int    $roleId   The ID of the user's role.
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int    $roleId
    ) {}

    /**
     * Creates a new instance of the class from an associative array.
     *
     * @param array $data Associative array containing 'name', 'email', 'password', and 'role_id' keys.
     * @return self Returns an instance of the class populated with the provided data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            roleId: $data['role_id'],
        );
    }


    /**
     * Converts the StoreUserDTO object properties to an associative array.
     *
     * @return array{
     *     name: string,
     *     email: string,
     *     password: string,
     *     role_id: int
     * }
     *     Returns an array containing the user's name, email, password, and role ID.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->roleId,
        ];
    }
}