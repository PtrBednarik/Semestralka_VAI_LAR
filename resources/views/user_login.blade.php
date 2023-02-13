@include('partials/header')

<div style="height: 100vh">
    <form action="{{ route('user_login_post') }}" method="post">
        <section class="login_section">
            <h2 style="margin-top: 10%">Prihlásenie</h2>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input name="username" type="text" placeholder="Username" required>
            <input name="password" type="password" placeholder="Heslo" id="loginPasswd" class="passwdInput" required><br>
            <div class="showP" style="text-align: center !important;">
                <label><input class="showPasswd" type="checkbox"  onclick="passwordUnhidden('loginPasswd')">Ukáž heslo!</label>
            </div>
            <button class="login_button" value="submit" type="submit">Prihlásiť</button>
            @if (isset($errors) && count($errors) > 0)
                <div class="login-error">{{$errors->first()}}</div>
            @endif

            <br>
            <a style="text-decoration: none; padding: 5px; font-size: 15px; color: #eb6d3f" href="/register">Registrovať</a>
        </section>
    </form>
</div>


@include('partials/footer')
