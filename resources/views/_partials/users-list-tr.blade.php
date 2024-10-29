@if($users->success)
    @foreach($users->users as $user)
        <tr>
            <td>
                <img src="{{$user->photo}}" style="width: 70px;">
            </td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->phone}}</td>
            <td>{{$user->position}}</td>
            <td>
                <a href="{{route('user.show', $user->id)}}"><i class="fa-solid fa-eye"></i></a>
            </td>
        </tr>
    @endforeach
@endif
