@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                 <div class="alert alert-danger">
                     {{ session('error') }}
                 </div>
            @endif
            <a href="{{ route('photo.create') }}" class="btn btn-success" style="margin-bottom: 10px"><i class="fa fa-plus">New Photo</i></a>
            <div class="panel panel-default">
                <div class="panel-heading">Photo list</div>
                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($photos as $photo)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $photo->id }}</div>
                                </td>
                                <td class="table-text">
                                    <div><img src="/storage/{{ $photo->name }}" alt="photo" width="50%"></div>
                                    <div>{{ $photo->user->name }}</div>
                                </td>
                                @if($user->id === $photo->user_id)
                                <td>
                                    <a href="{{ route('photo.edit', $photo->id ) }}" class="btn btn-warning" id="edit-photo-{{ $photo->id }}">
                                        <i class="fa fa-btn fa-edit"></i> Edit
                                    </a>
                                </td>
                                @endif
                                @if($user->id === $photo->user_id)
                                <td>
                                    <form action="{{ route('photo.destroy', $photo->id ) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" id="delete-photo-{{ $photo->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/script.js"></script>
@endsection
