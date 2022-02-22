@extends('layouts.app')

@section('content')
<div class="login">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <img src="/images/profile.png" alt="">
        <input type="email" placeholder="E-mail" id="" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
        <input type="password"  placeholder="Mot de passe" id="" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        <label>
            <input type="checkbox" checked="checked" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
          </label>
        <input type="submit" value="Se connecter"><a class="mo" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        <a href="{{ route('register') }}" class="Nv" >Créer nouveau compte</a>
    </form>

</div>

@endsection
