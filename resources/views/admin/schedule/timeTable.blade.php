@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">

        <h2 class="text-primary font-weight-bold">
            <i class="mr-2 fa-solid fa-calendar-days"></i>
            အတန်းနှစ်အလိုက် အချိန်ဇယားစာရင်း
        </h2>

        <p class="mb-0 text-muted">
            အပတ်စဉ်အချိန်ဇယားကြည့်ရန် ပညာသင်နှစ်ကို ရွေးချယ်ပါ။
        </p>

    </div>


    <div class="border-0 shadow-sm card">

        <div class="text-white card-header bg-primary">

            <h5 class="mb-0">
                <i class="mr-2 fa-solid fa-list"></i>
                ပညာသင်နှစ်များ
            </h5>

        </div>


        <div class="card-body">


            <div class="row">


                @forelse ($years as $item)

                    <div class="mb-4 col-md-4">


                        <a href="{{ route('schedule.viewSchedule', $item->id) }}"
                           class="text-decoration-none">


                            <div class="text-center border-0 shadow-sm card bg-primary">


                                <div class="py-5 text-white card-body">


                                    <i class="mb-3 fa-solid fa-users fa-3x"></i>


                                    <h3 class="mb-2 font-weight-bold">

                                        {{ $item->name }}

                                    </h3>


                                    <small>
                                        အချိန်ဇယားကြည့်ရန်
                                    </small>


                                </div>


                            </div>


                        </a>


                    </div>


                @empty


                    <div class="col-12">


                        <div class="py-5 text-center text-muted">


                            <i class="mb-3 fa-solid fa-folder-open fa-3x"></i>

                            <h5>
                                There is no data
                            </h5>


                        </div>


                    </div>


                @endforelse


            </div>


        </div>


    </div>


</div>


@endsection
