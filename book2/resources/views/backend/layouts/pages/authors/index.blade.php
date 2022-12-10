@extends('backend.layouts.app')

@section('admin-content')

<!-- Begin Page Content -->

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manage Authors</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add Author</a>

</div>
@include('backend.layouts.partials.messages')
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Author</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.authors.store') }}" method="post">
                    @csrf
                    <div class=" row">
                        <div class="col-12">
                            <label for="">Author Name</label>
                            <br>
                            <input type="text" class="form-control" name="name" placeholder="Author Name">
                        </div>
                        <div class="col-12">
                            <label for="">Author Details</label>
                            <br>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Author Description.."></textarea>
                        </div>
                    </div>
                    <div class=" mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Author List</h6>
            </div>
            <div class="card-body">

                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Name</th>
                            <th>Link</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($authors as $author)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $author->name}}</td>
                            <td>{{ $author->link}}</td>
                            <td>
                                <a class="btn btn-success" href="#editModal{{ $author->id }}" data-toggle="modal">
                                    <i class="fa fa-edit">Edit</i>
                                </a>
                                <a class="btn btn-danger" href="#deleteModal{{ $author->id }}" data-toggle="modal">
                                    <i class="fa fa-trash">Delete</i>
                                </a>
                            </td>
                        </tr>

                        <!---Edit Modal-->
                        <div class="modal fade" id="editModal{{ $author->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Author</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.authors.update',$author->id) }}" method="post">
                                            @csrf
                                            <div class=" row">
                                                <div class="col-12">
                                                    <label for="">Author Name</label>
                                                    <br>
                                                    <input type="text" class="form-control" name="name" placeholder="Author Name" value="{{ $author->name }}">
                                                </div>
                                                <div class="col-12">
                                                    <label for="">Author Details</label>
                                                    <br>
                                                    <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Author Description.."> {!! $author->description !!}</textarea>
                                                </div>
                                            </div>
                                            <div class=" mt-4">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>

                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---End Edit Modal-->

                        <!---Delete Modal-->
                        <div class="modal fade" id="deleteModal{{ $author->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete? </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.authors.delete',$author->id) }}" method="post">
                                            @csrf

                                            <div>
                                                {{ $author->name}} will be deleted !!
                                            </div>

                                            <div class=" mt-4">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>

                                                <button type="submit" class="btn btn-primary">Ok, Confirm</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---Delete Modal-->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>




@endsection