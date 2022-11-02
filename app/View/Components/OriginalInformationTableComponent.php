<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OriginalInformationTableComponent extends Component
{
    public $storeaction;
    public $updateaction;
    public $destroyaction;
    public $name;
    public $list;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($storeaction , $name , $list , $updateaction , $destroyaction)
    {
        //
        $this->name = $name;
        $this->list = $list;
        $this->storeaction = $storeaction;
        $this->updateaction = $updateaction;
        $this->destroyaction = $destroyaction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.original-information-table-component');
    }
}
