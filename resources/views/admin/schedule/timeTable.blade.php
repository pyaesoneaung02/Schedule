@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <div class="row">

            @if (count($years) != 0)
                @foreach ($years as $item)
                    <div class="mt-4 mb-4 col-md-4">

                        <a href="{{ route('schedule.viewSchedule', $item->id) }}" class="text-decoration-none">

                            <div class="text-center text-white shadow-lg card bg-info year-card">

                                <div class="py-5 card-body">

                                    <i class="mb-3 fa-solid fa-users fa-2x"></i>

                                    <h3 class="mb-0 fw-bold">
                                        {{ $item->name }}
                                    </h3>

                                </div>

                            </div>

                        </a>

                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <h2 class="text-center text-muted">There is no data</h2>
                </div>
            @endif

        </div>
    </div>

@endsection
