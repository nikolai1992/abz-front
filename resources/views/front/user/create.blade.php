@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create new task</h2>
        @if($errorMessage)
            <div class="alert alert-danger" role="alert">
                {{$errorMessage}}
            </div>
        @endif
        <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label>Name</label>
                    <input class="form-control" name="name" value="{!! old('name') !!}">
                    @if(isset($errors->name))
                        <div class="invalid-feedback">
                            {{$errors->name[0]}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input class="form-control" name="email" value="{!! old('email') !!}">
                    @if(isset($errors->email))
                        <div class="invalid-feedback">
                            {{$errors->email[0]}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Phone</label>
                    <input class="form-control" name="phone" value="{!! old('phone') !!}">
                    @if(isset($errors->phone))
                        <div class="invalid-feedback">
                            {{$errors->phone[0]}}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label>Position</label>
                    <select class="form-control" name="position_id">
                        <option value="">Select position</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                    @if(isset($errors->position_id))
                        <div class="invalid-feedback">
                            {{$errors->position_id[0]}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Photo</label>
                    <input type="file" name="photo" id="user_profile_image_path" />
                    <img style="width: 150px;" src="" class="img-select profile preview_image">
                    @if(isset($errors->photo))
                        <div class="invalid-feedback">
                            {{$errors->photo[0]}}
                        </div>
                    @endif
                </div>
            </div><br>
            <div class="row mt-3">
                <div class="col-md-2">
                    <button class="btn btn-primary">Save</button>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-warning" href="{{route('main.page')}}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $('#user_profile_image_path').on('change', function() {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => $('.preview_image').attr('src', e.target.result).show();
            reader.readAsDataURL(file);
        });

    </script>
@endsection
