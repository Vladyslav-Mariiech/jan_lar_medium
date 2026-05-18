@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit photo</div>
                <div class="panel-body">
                    @include('common.errors')
                    <form action="{{ route('photo.update', $photo->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="photo-name" class="col-sm-3 control-label">Current photo</label>
                            <div class="col-sm-6">
                                @if($photo->name)
                                     <div class="form-group">
                                         <div class="col-sm-6">
                                             <img src="{{ url('storage/' . $photo->name) }}" alt="Current Photo" class="img-thumbnail" style="max-height: 200px;">
                                         </div>
                                     </div>
                                @endif
                                <input type="file" name="photo" id="photo-name"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-plus"></i> Edit photo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
