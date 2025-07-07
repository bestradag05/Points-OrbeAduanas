<?php

namespace App\Traits;


trait HasTrace
{
    public function registerTrace($action, $justification = null)
    {
        return $this->traces()->create([
            'action' => $action,
            'justification' => $justification,
            'user_id' => auth()->id(),
        ]);
    }
}