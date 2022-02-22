@extends('layouts.app')

@section('content')
<div class="login">
    <form method="POST" action="{{ route('register') }}" style="height: 80vh;" enctype="multipart/form-data">
        @csrf
        <img src="/images/profile.png" alt="">
        <input type="text" placeholder="Nom et Prenom *" @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        <input type="text" placeholder="Numéro téléphone *"  @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
        @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
        <input autocomplete="off" type="email"  placeholder="E-mail *" id=""  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        <input type="password"  placeholder="Mot de passe *" id=""  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

        <input type="password"  placeholder="Confirmer le Mot de passe *" id="" name="password_confirmation" required autocomplete="new-password">
        <label for="image">Ajouter une photo profile :<input type="file" name="image" id="image"></label>
        <input type="submit" value="S’inscrire">
    </form>
</div>
@endsection
