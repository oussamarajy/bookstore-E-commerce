@extends('Master.MasterDash')
@section('title')
{{ Auth::user()->nom.' | Modifier' }}
@endsection

@section('content')
<div class="container">
    <div class="row gutters">
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
    <div class="card h-100">
        <div class="card-body">
            <div class="account-settings">
                <div class="user-profile">
                    <div class="user-avatar">
                        <img src="{{"/images/users"."/". Auth::user()->image }}" alt="{{ Auth::user()->nom }}">
                    </div>
                    <h5 class="user-name">{{ Auth::user()->nom }}</h5>
                    <h6 class="user-email">{{ Auth::user()->email }}</h6>
                </div>
                <div class="about">
                    <h5>Date d'adhésion</h5>
                    <p>{{ Auth::user()->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
        <form action="{{ route('admin.profile-update', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
            @csrf
    <div class="card h-100">
        <div class="card-body">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h6 class="mb-2 text-primary">Données personnelles</h6>
                </div>
                @if ($errors->any())
                <ul>
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <li>{{ $error }}</li>
                    </div>
                @endforeach
            </ul>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="fullName">Nom Complet</label>
                        <input type="text" class="form-control" id="fullName" name="nom" value="{{ Auth::user()->nom }}" placeholder="Enter full name">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="eMail">Email</label>
                        <input type="email" value="{{ Auth::user()->email }}" name="email" class="form-control" id="eMail" placeholder="Enter email ID">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" value="{{ Auth::user()->phone }}" name="phone" class="form-control" id="phone" placeholder="Enter phone number">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="pass">Mot de passe</label>
                        <input placeholder="********" type="password" class="form-control" name="password" id="pass">
                        Confirmer mot de passe
                        <input placeholder="********" class="form-control" type="password" name="password_confirmation" id="pass">
                    </div>
                </div>
            </div>
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h6 class="mt-3 mb-2 text-primary">Address</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input type="name" value="{{ Auth::user()->ville }}" name="ville" class="form-control" id="ville" placeholder="votre ville">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="region">Région</label>
                        <input type="name" class="form-control" value="{{ Auth::user()->region }}" id="region" name="region" placeholder="Enter Street">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="zIp">Code Postal</label>
                        <input type="text" value="{{ Auth::user()->code_postal }}" name="codepostal" class="form-control" id="zIp" placeholder="Zip Code">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="pays">Pays</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->pays }}" name="pays" id="pays" placeholder="Entrer votre pays">
                    </div>
                </div>
                <div class="row gutters mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="text-right">
                           <input class="form-control" type="file" name="image" id="image">
                           <img style="width: 60px; margin-top:5px" src="{{ '/images/users'.'/'.Auth::user()->image }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="text-right">
                        <a href="/user/profile" class="btn btn-secondary">Annuler</a>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </form>
    </div>
    </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
