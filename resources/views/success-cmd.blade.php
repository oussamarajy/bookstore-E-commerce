@extends('Master.MasterHome')
@section('title')
    Commande Envoyée
@endsection

@section('content')
    <div class="container" style="display: flex; flex-direction:column; justify-content:center; align-items:center; text-align:center">

            <img class="img-fluid mt-3" src="{{ asset('images/delivery.gif') }}" alt="commande succès">
            <div class="row w-100 text-uppercase">
            <p class="text-white bg-info p-3 text-center fw-bold mt-3 shadow-sm">La commande Nº {{ session('nbcmd') }} passée avec succès</p>
        </div>
    </div>
@endsection
