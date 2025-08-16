<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\UnrecognizedFaces;
use App\Models\RecognizedFace;

class ReportComponent extends Component
{
    #[Url]
    public $search = '';
    #[Url]
    public $startDate;
    #[Url]
    public $endDate;
    public $data = [];
    public $order = 'asc';
    public $dataType = 'recognized';

    public function mount()
    {

        $this->loadData();
    }


    public function updated($property)
    {
        if (in_array($property, ['search', 'startDate', 'endDate', 'order', 'dataType'])) {
            $this->loadData();
        }
    }

    public function toggleOrder()
    {
        $this->order = $this->order === 'asc' ? 'desc' : 'asc';
        $this->loadData();
    }

    public function setDataType($type)
    {
        $this->dataType = $type;
        $this->loadData();
    }


    private function getStartDate()
    {
        return $this->startDate ?: Carbon::minValue()->toDateTimeString();
    }

    private function getEndDate()
    {
        return $this->endDate ?: Carbon::now()->endOfDay()->toDateTimeString();
    }

    private function loadData()
    {
        $model = $this->dataType === 'recognized' ? RecognizedFace::class : UnrecognizedFaces::class;

        $query = $model::whereBetween('date_time', [$this->getStartDate(), $this->getEndDate()]);

        if ($this->dataType === 'recognized') {
            $query->whereHas('face', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
        }

        $data = $query->get();

        $this->data = $this->dataType === 'recognized'
            ? $this->processRecognizedData($data)
            : $this->processUnrecognizedData($data);
    }

    private function processRecognizedData($data)
    {
        return $data
            ->groupBy(fn($item) => $item->face_id . '_' . Carbon::parse($item->date_time)->format('Y-m-d'))
            ->map(fn($records) => [
                'enter' => $records->firstWhere('category', 'ENTER'),
                'leave' => $records->firstWhere('category', 'LEAVE'),
                'type'  => 'recognized',
            ])
            ->filter(fn($item) => $item['enter'] || $item['leave'])
            ->sortBy($this->getSortKey())
            ->values();
    }

    private function processUnrecognizedData($data)
    {
        $grouped = [];
        $enters = $data->where('category', 'ENTER')->values();
        $leaves = $data->where('category', 'LEAVE')->values();

        while ($enters->isNotEmpty() || $leaves->isNotEmpty()) {
            $grouped[] = [
                'enter' => $enters->shift(),
                'leave' => $leaves->shift(),
                'type'  => 'unrecognized',
            ];
        }

        return collect($grouped)->sortBy($this->getSortKey());
    }

    private function getSortKey()
    {
        return $this->order === 'asc'
            ? fn($item) => $item['enter']?->id ?? $item['leave']?->id
            : fn($item) => - ($item['enter']?->id ?? $item['leave']?->id);
    }

    public function render()
    {
        return view('livewire.report-component');
    }
}
