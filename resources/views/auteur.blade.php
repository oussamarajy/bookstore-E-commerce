@extends('Master.MasterHome')

@section('title')
{{ 'Lire Sagesse | '.$auteur->nom }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mt-4 my-4 text-center align-items-center" style="justify-content: center;">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
      <img class="img-auteur shadow-sm" src="{{ '/images/auteurs/'.$auteur->image }}" alt="image auteur">
    </div>
    </div>
    </div>

      <div class="col-md-2">
          <div class="card">
              <div class="card-body">
                  <div class="card-title">
      <h4>{{ $auteur->nom }}</h4>
    </div>
    <div class="card-text">
      <p>{{ $auteur->bio }}</p>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="row mt-4 my-4">
        <div class="col-md-7 col-sm-10 m-auto">
         <form action="{{ route('auteur.searchlivre') }}" method="GET" class="d-flex my-2">
            <input type="hidden" value="{{ $auteur->id }}" name="id">
             <input class="form-control me-sm-2 shadow-sm" name="search" type="text" placeholder="Entrer un mot clé du livre...">
             <button class="btn btn-outline-dark px-5 shadow-sm" type="submit">Rechercher</button>
         </form>
        </div>

    </div>
   </div>

   <div class="container-fluid w-75">
    @if ($livreparaut->count() >= 1)
    <div class="row">

        @foreach ($livreparaut as $livre )
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
@endsection
