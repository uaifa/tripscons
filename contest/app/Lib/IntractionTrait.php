<?php
namespace App\Lib;

trait IntractionTrait {
    public function modalAction($id, $action)
    {
        $this->dispatchBrowserEvent("modalAction", [
            'id' => $id,
            'action' => $action
        ]);
    }

    public function modalOpen($id)
    {
        $this->dispatchBrowserEvent("modalAction", [
            'id' => $id,
            'action' => 'show'
        ]);
    }

    public function modalClose($id)
    {
        $this->dispatchBrowserEvent("modalAction", [
            'id' => $id,
            'action' => 'hide'
        ]);
    }

    public function alert($title, $text, $icon, $confirmButtonText = 'Close')
    {
        $this->dispatchBrowserEvent("alert", [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
            'confirmButtonText' => $confirmButtonText,
        ]);
    }
}
