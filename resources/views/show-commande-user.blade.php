@extends('Master.MasterDashUser')

@section('title')
    details commande @foreach ($commande as $cmd )
    {{ $cmd->id }}
@endforeach
@endsection

@section('content')


<div class="container">
    <div class="row">
        @foreach ($commande as $cmd )
        <input type="hidden" value="{{ $cmd->id }}" id="idcmd">
        <div class="col-lg-6 mt-3">
            <div class="card shadow-lg">

                <div style="background-color: #219ebc; border-radius:.25rem" class="card-title text-center text-white position-relative">
                    <h5>informations de livraison</h5>
                </div>
                <div class="card-body">
                    <table class="table table-responsive">

                            <tr>
                                <th>Date de Commande</th>
                                <th>Nom Complet</th>
                                <th>Numéro Télé</th>
                            </tr>



                        <tr>
                        <td><b>{{ $cmd->created_at }}</b></td>
                        <td><i>{{ $cmd->ship_nom.' '.$cmd->ship_prenom }}</i></td>
                                <td>{{ $cmd->ship_phone }}</td>
                        </tr>

                        </table>
                    </div>
                </div>
                <div class="card mt-3 shadow-lg">
                    <div class="card-body">
                        <table class="table table-responsive">
                            <tr>
                        <th>Adresse</th>
                                <th>Région</th>
                                <th>Ville</th>
                                <th>Code Postal</th>
                                </tr>



                        <tr>
                        <td><i>{{ $cmd->shipadresse }}</i></td>
                        <td><i>{{ $cmd->ship_region }}</i></td>
                                <td>{{ $cmd->ship_ville }}</td>
                                <td>{{ $cmd->ship_code_postal }}</td>
                        </tr>

                        </table>
                </div>
            </div>

        </div>
        @endforeach
        <div class="col-lg-6 mt-3">
<div class="card shadow-lg">
    <div style="background-color: #219ebc; border-radius:.25rem" class="card-title text-center text-white">
        <h5>List des Produits</h5>
    </div>
    @if(session('successdele'))
    <div class="alert alert-success">
        {{ session('successdele') }}
    </div>
@endif
    <div class="card-body" style="height:40vh; overflow-y: scroll;">

        <table class="table table-responsive">

                    <tr>
                    <th>Photo</th>
                    <th>title</th>
                    <th>Quantité</th>
                    <th>PU</th>
                    </tr>
                    @foreach ( $livres as $livre )


                    <tr>
                    <td><img style="width: 80px;" class=" img-thumbnail" src="{{ asset('images/livres').'/'.$livre->image }}" alt=""></td>
                    <td>{{ $livre->titre }}</td>
                    <td>{{ $livre->quantity }}</td>
                    <td>{{ $livre->prix_unitaire }} DH</td>
                </tr>
                    @endforeach
            </table>
    </div>
    <table class="table table-responsive text-center fw-bold fs-5">
        <tr>

            <th>Total Quantité</th>
            <th>Montant</th>
        </tr>
      @foreach ($commande as $cmd )

        <tr>
            <td>{{ $cmd->totalq }}</td>
            <td>{{ $cmd->totalr }} DH</td>
        </tr>
            @endforeach
    </table>
</div>

        </div>



    </div>
</div>
@endsection


