@extends('Master.MasterHome')
@section('title')
   Acceuil
@endsection

@section('content')
<div class="mainy">


<div class="gallery js-flickity"
  data-flickity-options='{ "wrapAround": true, "autoPlay": 4000 }'>
  @foreach ($promotions as $promo )
  @php
  $exist = false
@endphp

  <div class="gallery-cell">
      <div class="main">
    <img src="{{ '/images/livres/'.$promo->image }}" alt="img"><div class="discount d-flex align-items-center justify-content-center fs-3 bg-danger"><span>@php
        echo '-'.floor($promo->reduction).'%'
    @endphp</span></div>
    <h2>{{ $promo->titre }}</h2>
    <em>{{ $promo->citation }}</em>
    <form action="{{ route('panier.ajouter') }}" method="post">
        @csrf
        <input type="hidden" value="{{ $promo->id }}" name="idlivre">
        @foreach (Cart::content() as $array )
            @if($array->id == $promo->id)
            @php
                $exist = true
            @endphp

            @endif
        @endforeach
        @if($exist == true)
        <p class=" fst-italic fs-6 text-info">déjà ajouté</p>
        @else
   <input type="submit" value="Ajouter au panier" class="btn btn-info text-sm-center text-white my-3 btnpanier">
    @endif
</form>
</div>
  </div>
  @endforeach
</div>
</div>

<hr class="mt-5">
<h5 class="mb-4 w-75 m-auto btn-secondary text-center">NOUVEAUX LIVRES</h5>
<hr class="mt-3">
<div class="container-fluid w-75">
    @if ($livres->count() >= 1)
    <div class="row">

        @foreach ($livres as $livre )
        @php
        $exist = false
    @endphp

        <div class="col-lg-3 col-md-6 col-sm-8 text-center my-3">
            <div class="card shadow-lg h-100 cardy">

                    <img class="img-thumbnail h-100" src="{{ '/images/livres/'.$livre->image }}" alt="">
                    <div class="card-title font-weight-bold font-monospace text-dark">
                        <a class=" text-decoration-none text-dark" href="/livre/{{ $livre->id.'/'.$livre->slug }}"><h4 class="titreLivre">{{ $livre->titre }}</h4></a>
                    </div>
                    <div class="card-text text-dark small">
                        <p ><a href="{{ route('auteur.show', [$livre->idauteur, $livre->slugauteur]) }}" class="text-secondary text-decoration-underline">{{ $livre->nom }}</a></p>
                        <del class="small h6 text-danger">@php
                           echo floor($livre->prix*1.5);
                        @endphp DH</del><span class=" fw-bold">&nbsp;&nbsp;{{ $livre->prix }} DH</span>
                    </div>
                    <div class="card-text">
                        <form action="{{ route('panier.ajouter') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $livre->id }}" name="idlivre">
                            @foreach (Cart::content() as $array )
                                @if($array->id == $livre->id)
                                @php
                                    $exist = true
                                @endphp

                                @endif
                            @endforeach
                            @if($exist == true)
                            <p class=" fst-italic fs-6 text-info">déjà ajouté</p>
                            @else
                       <input type="submit" value="Ajouter au panier" class="btn btn-info text-sm-center text-white my-3 btnpanier">
                        @endif
                    </form>
                    </div>
                </div>
            </div>

        @endforeach
        @else
        <div class="row text-center">

               <h4 class="text-secondary fw-bold bg-white shadow-sm p-3">Aucun résultat.</h4>

        </div>
        @endif






    </div>

</div>
</div>
<div class="text-center mt-3">
    <a href="{{ route('all.livre') }}" type="button" class="btn btn-warning text-white px-5">Voir plus</a>
  </div>
<hr class="mt-5">
<h5 class="mb-4 w-75 m-auto btn-secondary text-center">LES CATEGORIES</h5>
<hr class="mt-3">
<div class="container">
    <div class="row">
        @foreach ($categories as $categorie)


        <div class="col-lg-3 col-md-6 col-sm-8 text-center my-3">
            <div class="card h-100 shadow-lg cardy m-auto">
                <img class=" img-thumbnail h-100" src="{{ '/images/categories/'.$categorie->image }}" alt="">
                <div class="card-body">
                    <div class="card-title">
                        <a href="{{ route('categorie.show', [$categorie->id, $categorie->slug_cat]) }}" class="text-dark text-decoration-none fw-bold fs-6">{{ $categorie->titre_cat }}</a>
                        <a href="{{ route('categorie.show', [$categorie->id, $categorie->slug_cat]) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="text-center mt-3">
    <a href="{{ route('all.categorie') }}" type="button" class="btn btn-warning text-white px-5">Voir plus</a>
  </div>
  <hr class="mt-5">
<h5 class="mb-4 w-75 m-auto btn-secondary text-center text-uppercase">moyens de paiement</h5>
<hr class="mt-3">
<div class="container">
    <div class="row">
        <img style="width: 400px;" class=" img-thumbnail m-auto" src="/images/cash.jpg" alt="">
    </div>
</div>
@endsection
