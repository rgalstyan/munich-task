<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Product;
use App\Models\User;

final class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function destroy(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}
