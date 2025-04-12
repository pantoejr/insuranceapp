@extends('layouts.app')
@section('content')
    @php
        $sections = [
            [
                'id' => 'section1',
                'title' => 'Details',
                'view' => 'clients.partials.client_details',
                'icons' => 'person',
            ],
            [
                'id' => 'section2',
                'title' => 'Employees',
                'view' => 'clients.partials.client_employees',
                'icons' => 'people',
            ],
            [
                'id' => 'section3',
                'title' => 'Attachments',
                'view' => 'clients.partials.client_attachments',
                'icons' => 'paperclip',
            ],
            [
                'id' => 'section4',
                'title' => 'Policies',
                'view' => 'clients.partials.policy_list',
                'icons' => 'file-earmark-text',
            ],
            [
                'id' => 'section5',
                'title' => 'Claims',
                'view' => 'clients.partials.client_claims',
                'icons' => 'journal-text',
            ],
            [
                'id' => 'section6',
                'title' => 'Services',
                'view' => 'clients.partials.client_services',
                'icons' => 'list-task',
            ],
        ];
    @endphp

    @can('view-client-details')
        <x-section-navigation :sections="$sections" :model="$model" />
    @endcan
@endsection
