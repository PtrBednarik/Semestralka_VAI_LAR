@include('partials/header')

<form action="{{ route('user_register_post') }}" method="post">
    <div class="registration-container">
        <h1>Registrácia</h1>
        <hr>

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <label for="name"><b>Meno</b></label>
        @if($errors->has('first_name'))
            <span class="text-danger">{{ $errors->first('first_name') }}</span>
        @endif
        <input class="input-reg" type="text" placeholder="Meno..." name="first_name" id="name" required>

        <label for="surname"><b>Priezvisko</b></label>
        @if($errors->has('last_name'))
            <span class="text-danger">{{ $errors->first('last_name') }}</span>
        @endif
        <input class="input-reg" type="text" placeholder="Priezvisko..." name="last_name" id="surname" required>

        <label for="email"><b>Email</b></label>
        @if($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif
        <input class="input-reg" type="email" placeholder="Email..." name="email" id="email" required>

        <label for="username"><b>Prihlasovacie meno</b></label>
        @if($errors->has('username'))
            <span class="text-danger">{{ $errors->first('username') }}</span>
        @endif
        <input class="input-reg" type="text" placeholder="Prihlasovacie meno..." name="username" id="username" required>

        <label for="password"><b>Heslo</b></label>
        @if($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
        <input class="input-reg passwdInput" type="password" id="regPSWDInput" placeholder="Heslo..." name="password" required>
        <div class="showP">
            <label><input class="showPasswd" type="checkbox" onclick="passwordUnhidden('regPSWDInput')">Ukáž heslo!</label>
        </div>
        <button type="submit" class="regbtn">REGISTROVAŤ</button>
    </div>

    <div class="container signin">
        <p>Už máš účet? <a href="/login">Prihlás sa</a>.</p>
    </div>
{{--    {{$errors}}--}}
</form>

@include('partials/footer')
