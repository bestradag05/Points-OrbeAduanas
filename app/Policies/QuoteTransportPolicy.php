<?php

namespace App\Policies;

use App\Models\QuoteTransport;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuoteTransportPolicy
{

    public function before(User $user, $ability)
    {
        return $user->hasRole('Super-Admin') ? true : null;
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Transporte');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, QuoteTransport $quoteTransport): bool
    {
        $ownerId = optional($quoteTransport->commercial_quote?->personal?->user)->id;

        $isCreator          = $ownerId === $user->id;
        $rolTransporte      = $user->hasRole('Transporte');

        return $isCreator || $rolTransporte;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, QuoteTransport $quoteTransport): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, QuoteTransport $quoteTransport): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, QuoteTransport $quoteTransport): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, QuoteTransport $quoteTransport): bool
    {
        //
    }
}
