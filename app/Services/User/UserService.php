<?php

namespace App\Services\User;

use App\DataTransferObjects\User\Request\IndexUsersDTO;
use App\DataTransferObjects\User\Request\StoreUserDTO;
use App\DataTransferObjects\User\Request\UpdateUserDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{

    /**
     * UserService constructor.
     * Initializes a new instance of the UserService class.
     */
    public function __construct() {}

    /**
     * Retrieve a paginated list of users with optional filtering and sorting.
     *
     * @param IndexUsersDTO $dto Data transfer object containing filter criteria,
     *                           sorting parameters, and pagination settings.
     *                           - filters['search']: Optional search term to filter users by name or email
     *                           - orderBy: Field name to sort results by
     *                           - orderDirection: Sort direction ('asc' or 'desc')
     *                           - limit: Number of results per page
     *                           - page: Current page number
     *
     * @return LengthAwarePaginator Paginated collection of users matching the specified criteria
     */
    public function index(IndexUsersDTO $dto): LengthAwarePaginator
    {
        $query = User::query();

        if (!empty($dto->filters['search'])) {
            $searchTerm = $dto->filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $query->orderBy($dto->orderBy, $dto->orderDirection);

        return $query->paginate($dto->limit, ['*'], 'page', $dto->page);
    }

    /**
     * Stores a new user in the database.
     *
     * @param StoreUserDTO $data Data transfer object containing user information.
     * @return User The newly created user instance.
     */
    public function store(StoreUserDTO $data): User
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
    public function delete(User $user): bool
    {
        return $user->delete();
    }


    /**
     * Update a user with the provided data.
     *
     * @param User $user The user instance to update.
     * @param UpdateUserDTO $data The data transfer object containing the user data to update.
     * @return User The updated user instance, or null if the update fails.
     */
    public function update(User $user, UpdateUserDTO $data): User
    {
        $user->update($data->toArray());
        return $user;
    }
}
