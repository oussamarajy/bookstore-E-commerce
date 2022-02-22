@extends('Master.MasterHome')
@section('title')
Votre Panier

@endsection

@section('content')
@if(Cart::content()->count()>=1)
<form action="{{ route('panier.update') }}" method="get">
    @csrf

<section class="h-100 h-custom" style="background-color: #a0ebf8;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
          <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-lg-8">
                  <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                      <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                      <h6 class="mb-0 text-muted fw-bold">Livres : {{ Cart::content()->count() }}</h6>
                    </div>
                    @php
                        $total = 0;

                        $taux = 0;
                    @endphp
                    @foreach (Cart::content() as $array )
                    @foreach ($livres as $livre )
                    @php
                    $found = false;
                    @endphp
                    @if($livre->id == $array->id)

                    @foreach ( $promotions as $promo)
                    @if($livre->id==$promo->id && $promo->affichage)
                    @php
                           $total +=  ($livre->prix - (($livre->prix*$promo->reduction)/100))*$array->qty;
                            $found = true;
                            $taux = $promo->reduction;
                             break;
                    @endphp
                    @endif
                    @endforeach
                     @if (!$found)
                     @php
                    $total += $livre->prix*$array->qty;
                    $taux = 0;
                    @endphp

                     @endif

                    <hr class="my-4">

                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                      <div class="col-md-2 col-lg-2 col-xl-2">
                        <img
                          src="{{ '/images/livres/'.$livre->image }}"
                          class="img-fluid rounded-3" alt="Cotton T-shirt">
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-3">
                        <h6 class="text-muted">Livre</h6>
                        <h6 class="text-black mb-0">{{ $livre->titre }}</h6>
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-2 d-flex">


                        <input id="form1" min="0" name="quantity[]" value="{{ $array->qty }}" type="number"
                          class="form-control form-control-sm" />


                      </div>
                      <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                        <h6 class="mb-0">{{ $livre->prix }} DH</h6><sub class="text-success fw-bold">@php
                            if($taux != 0)
                            echo '-'.$taux.'% (promotion)';
                        @endphp</sub>
                      </div>
                    </form>
                      <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                          <form action="{{ route('panier.delete') }}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" name="idlivrecart" value="{{ $array->rowId }}">
                        <button type="submit" class="text-muted bg-white border-0"><i class="fas fa-times"></i></button>
                    </form>
                      </div>
                    </div>


                    @endif

                    @endforeach
                @endforeach




                    <div class="pt-5">
                      <h6 class="mb-0"><a href="{{ url()->previous() }}" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>Retour</a></h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 bg-grey">
                  <div class="p-5">

                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-5">
                      <h5 class="text-uppercase">Total TTC :</h5>
                      <h5>{{ $total }} DH</h5>
                    </div>

                    <button type="submit" class="btn btn-dark btn-block btn-lg fcmd text-uppercase fs-6"
                      data-mdb-ripple-color="dark">Finaliser La Commande</button>
                      <a class="btn btn-secondary mt-3 btn-block btn-lg fcmd2 text-uppercase fs-6"
                      data-mdb-ripple-color="dark" href="{{route('all.livre')}}">Continuer l'achat</a>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @else



<div class="container" style="display: flex; flex-direction:column; justify-content:center; align-items:center; text-align:center">


    <img class="img-fluid shadow-sm m-3" src="{{ asset('images/empty-cart.gif') }}" alt="Panier Vide">

<div class="oberv">
    <h3 class=" text-muted fw-bold"> Votre panier est vide !</h3>
    <p>Explorez nos catégories et découvrez nos meilleures offres!</p>

</div>
<a href="/" class="bg-warning shadow-sm text-white fw-bold p-3 text-decoration-none">Commencez vos achats</a>
</div>
  @endif


@endsection
