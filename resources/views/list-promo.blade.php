@extends('Master.MasterHome')

@section('title')
Lire Sagesse | Promotions
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mt-4 my-4">
        <div class="col-md-7 col-sm-10 m-auto">
         <form action="{{ route('allsearch.livre') }}" method="GET" class="d-flex my-2">
             <input class="form-control me-sm-2 shadow-sm" name="search" type="text" placeholder="Entrer un mot clé du livre...">
             <button class="btn btn-outline-dark px-5 shadow-sm" type="submit">Rechercher</button>
         </form>
        </div>

    </div>
   </div>

   <hr class="mt-5">
<h5 class="mb-4 w-75 m-auto btn-secondary text-center">Les promotions</h5>
<hr class="mt-3">
<div class="container-fluid w-75">
    @if ($livres->count() >= 1)
    <div class="row">

        @foreach ($livres as $livre )
        @php
        $exist = false
    @endphp

        <div class="col-lg-3 col-md-6 col-sm-8 text-center my-3">
            <div class="card shadow-lg h-100 cardy position-relative">

                    <img class="img-thumbnail h-100" src="{{ '/images/livres/'.$livre->image }}" alt=""><div class="discount d-flex align-items-center justify-content-center fs-3 bg-danger text-white position-absolute top-0" style="transform: translateY(250px);"><span>@php
                        echo '-'.floor($livre->reduction).'%'
                    @endphp</span></div>
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
<div class="d-flex justify-content-center mt-5">
{{ $livres->links() }}
</div>
@endsection
