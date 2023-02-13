@include('partials.header')

<div class="title-container">
    <h3>Používatelia</h3>
</div>

@if($message = Session::get('success'))

    <div class="alert alert-success">
        {{ $message }}
    </div>

@endif


<section>
    <div class="container">
        <div class="row" style="margin: 20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Používatelia</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Meno</th>
                                    <th>Priezvisko</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Admin?</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (isset($users))
                                    @foreach($users as $user)
                                        @if($user->is_admin == 0)
                                            <tr>
                                                <td> {{ $user->first_name }}</td>
                                                <td> {{ $user->last_name }}</td>
                                                <td> {{ $user->username }}</td>
                                                <td> {{ $user->email }}</td>
                                                <td> {{ $user->is_admin }}</td>
                                                <td>
                                                    <form method="POST"
                                                          action="{{ route('users.destroy', $user->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete User"
                                                                class="btn-sm btn-danger" value="Delete">Delete
                                                        </button>
                                                    </form>

                                                    <form method="POST"
                                                          action="{{ route('user_setAsAdmin', $user->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" title="Make admin"
                                                                class="btn-sm btn-info">Admin
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
