@extends('layouts.app')
@section('content')
    @php
        $sections = [
            [
                'id' => 'section1',
                'title' => 'Details',
                'view' => 'insurers.partials.insurer_details',
                'icons' => 'bi bi-person',
            ],
            [
                'id' => 'section2',
                'title' => 'Users',
                'view' => 'insurers.partials.user_list',
                'icons' => 'bi bi-people',
            ],
            [
                'id' => 'section3',
                'title' => 'Policies',
                'view' => 'insurers.partials.policies_list',
                'icons' => 'bi bi-paperclip',
            ],
        ];
    @endphp

    <x-section-navigation :sections="$sections" :model="$insurer" :users="$users" :policies="$policies" />
@endsection
