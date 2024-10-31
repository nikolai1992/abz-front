@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create new task</h2>
        @if($errorMessage)
            <div class="alert alert-danger" role="alert">
                {{$errorMessage}}
            </div>
        @endif
        <form id="addUserForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label>Name</label>
                    <input class="form-control form-data-field" name="name" value="{!! old('name') !!}">
                    <div class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input class="form-control form-data-field" name="email" value="{!! old('email') !!}">
                    <div class="invalid-feedback">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Phone</label>
                    <input class="form-control form-data-field" name="phone" value="{!! old('phone') !!}">
                    <div class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Position</label>
                    <select class="form-control form-data-field" name="position_id">
                        <option value="">Select position</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Photo</label>
                    <input type="file" class="form-data-field" name="photo" id="user_profile_image_path" />
                    <img style="width: 150px;" src="" class="img-select profile preview_image">
                    <div class="invalid-feedback">
                    </div>
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

        document.addEventListener("DOMContentLoaded", function () {
            const addUserForm = document.getElementById('addUserForm');

            function addUser(event) {
                event.preventDefault();

                const formData = new FormData(addUserForm);
                const token = `{{ Session::get('abz_token') }}`;

                fetch('{{config('app.abztestapiurl')}}/api/v1/users', {
                    method: 'POST',
                    headers: {
                        'token': `${token}`
                    },
                    body: formData
                })
                    .then(response => {
                        $('.invalid-feedback').text(null);
                        if (!response.ok) {
                            return response.json().then(data => {
                                let fails = '';
                                if (typeof data.fails !== 'undefined' && data.fails !== null) {
                                    Object.keys(data.fails).forEach(key => {
                                        data.fails[key].forEach(messageFail => {
                                            fails += `${messageFail}, `;
                                        });
                                    });
                                } else {
                                    for (const error in data.data) {
                                        $('#addUserForm .form-data-field[name="' + error + '"]').parent().find('.invalid-feedback').text(data.data[error][0]);
                                    }

                                }
                                if (data.errors) {
                                    Object.keys(data.errors).forEach(key => {
                                        // Get the input field and the error div for each field
                                        const inputField = document.querySelector(`[name="${key}"]`);
                                        const errorDiv = inputField.parentNode.querySelector('.invalid-feedback');

                                        // Set the error message if an error div exists
                                        if (errorDiv) {
                                            errorDiv.textContent = data.errors[key][0];
                                            inputField.classList.add('is-invalid');
                                        }
                                    });
                                }

                                throw new Error(data.message + " " + fails + " " + response.status);
                            });
                        }

                        return response.json();
                    })
                    .then(data => {
                        addUserForm.reset();
                        window.location.href = '{{route('token.delete')}}';
                    })
                    .catch(error => {
                        console.error('Error of user adding:', error);
                        alert(error);
                    });
            }

            addUserForm.addEventListener('submit', addUser);
        });

    </script>
@endsection
