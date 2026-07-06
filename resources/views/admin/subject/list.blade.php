@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between my-2">
            <div class="mb-4 d-sm-flex align-items-center justify-content-between">
                <h1 class="mb-0 text-gray-800 h3">Subjects List</h1>
            </div>
            <div class="my-2 d-flex justify-content-end">
                <div class="">
                    <form action="{{ route('subject.list')}}" method="GET">
                        <div class="input-group">
                            <input type="text" name="searchKey" value="" class="form-control"
                                placeholder="Search...">
                            <button type="submit" class="text-white btn bg-dark"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="">
            <div class="row">
                <div class="col">
                    <table class="table shadow-sm table-hover">
                      <thead class="text-white bg-danger">
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Long Name</th>
                          <th scope="col">Short Name</th>
                          <th scope="col">Time Number</th>
                          <th scope="col">Years</th>
                          <th scope="col">Majors</th>
                          <th scope="col">Created Date</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($subjects) != 0)
                        @foreach ($subjects as $item)
                            <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->long_name }}</td>
                            <td>{{ $item->short_name }}</td>
                            <td>{{ $item->time_number }}</td>
                            <td>{{ $item->year_name }}</td>
                            <td>{{ $item->major_name }}</td>
                            <td>{{ $item->created_at->format('j-F-Y')}}</td>
                            <td>
                                <a href="{{ route('subject.updatePage', $item->id)}}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{ route('subject.delete', $item->id)}}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8"><h5 class="text-center text-muted">There is no data</h5></td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                    <span class="d-flex justify-content-end">{{ $subjects->links() }}</span>
                </div>
            </div>
        </div>

    </div>
@endsection
