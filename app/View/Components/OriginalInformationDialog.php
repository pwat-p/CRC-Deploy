<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OriginalInformationDialog extends Component
{
    public $typename;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($typename)
    {
        //
        $this->typename = $typename;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.original-information-dialog');
    }
}
