@extends('admin.layouts.master')

@section('content')

<div class="mt-5 container-fluid">


    <!-- Page Heading -->
    <div class="mb-4 d-flex justify-content-between align-items-center">


        <div>

            <h2 class="text-primary font-weight-bold">

                <i class="mr-2 fa-solid fa-users"></i>

                User Account List

            </h2>


            <p class="mb-0 text-muted">

                Manage system user accounts.

            </p>

        </div>



        <div>


            <form action="{{ route('profile.adminList') }}" method="GET">


                <div class="input-group">


                    <input type="text"
                        name="searchKey"
                        value="{{ request('searchKey') }}"
                        class="form-control"
                        placeholder="Search...">



                    <button type="submit"
                        class="btn btn-primary">

                        <i class="fa-solid fa-magnifying-glass"></i>

                    </button>


                </div>


            </form>


        </div>


    </div>





    <div class="border-0 shadow-sm card">


        <div class="text-white card-header bg-primary">


            <h5 class="mb-0">

                <i class="mr-2 fa-solid fa-user-gear"></i>

                Users


            </h5>


        </div>




        <div class="card-body">


            <div class="table-responsive">


                <table class="table align-middle table-hover table-bordered">


                    <thead class="thead-light">


                        <tr class="text-center">

                            <th width="70">ID</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Address</th>

                            <th>Phone</th>

                            <th>Role</th>

                            <th width="150">Created Date</th>

                            <th width="100">Action</th>


                        </tr>


                    </thead>



                    <tbody>


                        @forelse ($user as $item)


                            <tr>


                                <td class="text-center">

                                    {{ $item->id }}

                                </td>


                                <td>

                                    {{ $item->name }}

                                </td>


                                <td>

                                    {{ $item->email }}

                                </td>


                                <td>

                                    {{ $item->address }}

                                </td>


                                <td>

                                    {{ $item->phone }}

                                </td>


                                <td class="text-center text-danger">

                                    {{ $item->role }}

                                </td>


                                <td class="text-center">

                                    {{ $item->created_at->format('d M Y') }}

                                </td>


                                <td class="text-center">


                                    <a href="{{ route('profile.userDelete', $item->id) }}"
                                        class="btn btn-sm btn-outline-danger">


                                        <i class="fa-solid fa-trash"></i>


                                    </a>


                                </td>


                            </tr>


                        @empty


                            <tr>


                                <td colspan="8"
                                    class="py-5 text-center text-muted">


                                    <i class="mb-2 fa-solid fa-user-slash fa-3x"></i>

                                    <br>

                                    There is no data


                                </td>


                            </tr>


                        @endforelse



                    </tbody>


                </table>



            </div>



            <div class="mt-3 d-flex justify-content-end">


                {{ $user->links() }}


            </div>


        </div>


    </div>



</div>

@endsection
