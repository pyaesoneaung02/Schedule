@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-flex justify-content-between align-items-center">

            <div>

                <h2 class="text-primary font-weight-bold">
                    <i class="mr-2 fa-solid fa-comment"></i>
                    Comment List
                </h2>

                <p class="mb-0 text-muted">
                    Manage comments.
                </p>

            </div>

            <div>

                <form action="" method="GET">

                    <div class="input-group">

                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                            placeholder="Search...">


                        <button type="submit" class="btn btn-primary">

                            <i class="fa-solid fa-magnifying-glass"></i>

                        </button>


                    </div>


                </form>


            </div>


        </div>

        <div class="border-0 shadow-sm card">


            <div class="text-white card-header bg-primary">


                <h5 class="mb-0">

                    <i class="mr-2 fa-solid fa-comment"></i>
                    
                    Comments

                </h5>


            </div>

            <div class="card-body">


                <div class="table-responsive">


                    <table class="table align-middle table-hover table-bordered">


                        <thead class="thead-light">


                            <tr class="text-center">


                                <th width="70">ID</th>

                                <th>Teacher Name</th>

                                <th>Message</th>

                                <th>Status</th>

                                <th width="180">Created Date</th>

                                <th width="120">Action</th>


                            </tr>


                        </thead>

                        <tbody>

                                <tr>


                                    <td class="text-center">


                                    </td>



                                    <td>


                                    </td>


                                    <td>

                                    </td>


                                    <td>


                                    </td>

                                    <td>

                                    </td>


                                    <td class="text-center">


                                        <a href=""
                                            class="btn btn-sm btn-outline-primary">

                                            <i class="fa-regular fa-eye"></i>

                                        </a>




                                        <a href=""
                                            class="btn btn-sm btn-outline-danger">

                                            <i class="fa-solid fa-trash"></i>

                                        </a>



                                    </td>



                                </tr>

                        </tbody>



                    </table>



                </div>





                {{-- <div class="mt-3 d-flex justify-content-end">


                    {{ $teachers->links() }}


                </div> --}}



            </div>



        </div>

    </div>
@endsection
