<?php 

namespace App\DataTransferObjects\Auth\Request;

class LoginCredentialsDTO
{
    /**
     * Data Transfer Object for user login credentials.
     *
     * @param string $email    The user's email address.
     * @param string $password The user's password.
     */
    public function __construct(
        public string $email,
        public string $password
    ) {}

    /**
     * Creates a new instance of the class from an associative array.
     *
     * @param array $data Associative array containing 'email' and 'password' keys.
     * @return self Returns an instance of the class populated with the provided data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
        );
    }
}
