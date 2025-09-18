<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileIcon extends Component
{
    /**
     * Create a new component instance.
     */

    public $path;


    public function __construct($path)
    {
        $this->path = $path;

       
    }
    

     public function iconClass()
    {
        $ext = strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
 
        return match ($ext) {
           'pdf' => 'fas fa-file-pdf text-danger',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'fas fa-file-image text-info',
            'doc', 'docx' => 'fas fa-file-word text-primary',
            'xls', 'xlsx' => 'fas fa-file-excel text-success',
            'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
            'zip', 'rar' => 'fas fa-file-archive text-muted',
            default => 'fas fa-file text-secondary',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.file-icon');
    }
}
