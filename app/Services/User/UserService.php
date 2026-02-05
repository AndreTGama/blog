<?php

namespace App\Http\Services\User;

use App\DataTransferObjects\User\Request\StoreUserDTO;
use App\Models\User;

class UserService
{
    
    /**
     * UserService constructor.
     * Initializes a new instance of the UserService class.
     */
    public function __construct()
    {
        
    }

    /**
     * Stores a new user in the database.
     *
     * @param StoreUserDTO $data Data transfer object containing user information.
     * @return User The newly created user instance.
     */
    public function store(StoreUserDTO $data)
    {
        return User::create($data->toArray());
    }

    /**
     * Retrieves a user by their unique identifier.
     *
     * @param string $id The unique identifier of the user.
     * @return User|null The user instance if found, or null if not found.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user is not found.
     */
    public function findById(string $id): ?User
    {
        return User::findOrFail($id);
    }

    /**
     * Deletes a user by their unique identifier.
     *
     * Finds the user by the provided ID and deletes the user if found.
     *
     * @param string $id The unique identifier of the user to delete.
     * @return bool Returns true if the user was deleted successfully, false otherwise.
     */
    public function delete(string $id): bool
    {
        $user = $this->findById($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    /**
     * Updates the user with the given ID using the provided data.
     *
     * @param string $id The ID of the user to update.
     * @param StoreUserDTO $data Data transfer object containing the updated user information.
     * @return User|null Returns the updated User object if found and updated, or null if the user does not exist.
     */
    public function update(string $id, StoreUserDTO $data): ?User
    {
        $user = $this->findById($id);
        if ($user) {
            $user->update($data->toArray());
            return $user;
        }
        return null;
    }
}