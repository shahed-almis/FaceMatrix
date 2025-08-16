<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UnrecognizedFaces;
use App\Models\RecognizedFace as ModelsRecognizedFace;

class RecognizedFace extends Component
{
    public function render()
    {
        $combinedData = collect()
            ->merge(
                ModelsRecognizedFace::where('category', 'ENTER')
                    ->get()
            )
            ->merge(
                UnrecognizedFaces::where('category', 'ENTER')
                    ->get()
            )
            ->sortBy('date_time')->reverse();

        return view('livewire.recognized-face', ['reconized' =>     $combinedData]);
    }
}
