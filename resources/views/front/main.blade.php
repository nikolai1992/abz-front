@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>Users</b></div><br>
                    @if($errorMessage)
                        <div class="alert alert-danger" role="alert">
                            {{$errorMessage}}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                            @if($abzToken)
                                <a class="btn btn-primary" href="{{route('register.page')}}">Register new</a>
                            @endif
                            <a class="btn btn-primary" href="{{route('token.get')}}">Get token</a>

                        </div>

                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @include('_partials.users-list-tr', compact('users'))
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-3">
                            <button class="show-more btn btn-primary" data-next_page="{{$users->page + 1}}" data-last_page="{{$users->total_pages}}">Show more</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.show-more').on('click', function () {
            var _this = $(this);
            var nextPage = _this.data('next_page');
            var lastPage = _this.data('last_page');
            $.get("/show-more/" + nextPage, function(data, status){
                $('table tbody').append(data);
                if (nextPage == lastPage) {
                    _this.remove();
                } else {
                    nextPage = nextPage + 1;
                    _this.data('next_page', nextPage);
                }
            });
        });

    </script>
@endsection

