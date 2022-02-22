@extends('Master.MasterHome')

@section('title')
Lire Sagesse | Auteurs
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mt-4 my-4">
        <div class="col-md-7 col-sm-10 m-auto">
         <form action="{{ route('allsearch.auteur') }}" method="GET" class="d-flex my-2">
             <input class="form-control me-sm-2 shadow-sm" name="search" type="text" placeholder="Entrer un nom d'auteur...">
             <button class="btn btn-outline-dark px-5 shadow-sm" type="submit">Rechercher</button>
         </form>
        </div>

    </div>
   </div>

   <hr class="mt-5">
   <h5 class="mb-4 w-75 m-auto btn-secondary text-center">TOUS LES AUTEURS</h5>
   <hr class="mt-3">
   <div class="container">
       <div class="row">
           @foreach ($auteurs as $auteur)


           <div class="col-lg-3 col-md-6 col-sm-8 text-center my-3">
               <div class="card h-100 shadow-lg cardy m-auto">
                   <img class=" img-thumbnail h-100" src="{{ '/images/auteurs/'.$auteur->image }}" alt="{{ $auteur->nom }}">
                   <div class="card-body">
                       <div class="card-title">
                           <a href="{{ route('auteur.show', [$auteur->id, $auteur->slug]) }}" class="text-dark text-decoration-none fw-bold fs-6">{{ $auteur->nom }}</a>
                       </div>
                   </div>
               </div>
           </div>
           @endforeach
       </div>
   </div>

<div class="d-flex justify-content-center mt-5">
{{ $auteurs->links() }}
</div>
@endsection
