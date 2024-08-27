<?php
namespace App\Observers;

use App\Models\Cover;

class CoverObserver
{
    /**
     * Handle the Cover "creating" event.
     */
    public function creating(Cover $cover)
    {
        $cover->order = Cover::max('order') + 1;
    }
}
