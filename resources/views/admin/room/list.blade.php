@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between my-2">
            <div class="mb-4 d-sm-flex align-items-center justify-content-between">
                <h1 class="mb-0 text-gray-800 h3">Rooms List</h1>
            </div>
            <div class="my-2 d-flex justify-content-end">
                <div class="">
                    <form action="{{ route('room.list') }}" method="GET">
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
                          <th scope="col">Name</th>
                          <th scope="col">Years</th>
                          <th scope="col">Majors</th>
                          <th scope="col">Created Date</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($rooms) != 0)
                        @foreach ($rooms as $item)
                            <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->year_name }}</td>
                            <td>{{ $item->major_name }}</td>
                            <td>{{ $item->created_at->format('j-F-Y')}}</td>
                            <td>
                                <a href="{{ route('room.updatePage', $item->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{ route('room.delete', $item->id)}}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6"><h5 class="text-center text-muted">There is no data</h5></td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                    <span class="d-flex justify-content-end">{{ $rooms->links() }}</span>
                </div>
            </div>
        </div>

    </div>
@endsection
