@extends('Master.MasterDash')

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
                    <button class="editliv text-white p-1" data-bs-toggle="modal" data-bs-target="#modellivraison"><i class="fas fa-edit"></i></button>
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
            <div class="card mt-3 shadow-lg">
                <div style="background-color: #219ebc; border-radius:.25rem" class="card-title text-center text-white">
                    <h5>informations de client</h5>
                </div>
                <div class="card-body">
                    <table class="table table-responsive">

                        <tr>
                    <th>Nom</th>
                            <th>E-mail</th>
                            <th>Ville</th>
                            <th>Phone</th>
                            </tr>



                    <tr>
                    <td><i>{{ $cmd->nom }}</i></td>
                    <td><i>{{ $cmd->email }}</i></td>
                            <td>{{ $cmd->ville }}</td>
                            <td>{{ $cmd->phone }}</td>
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
                    <th>Actions</th>
                    </tr>
                    @foreach ( $livres as $livre )


                    <tr>
                    <td><img style="width: 80px;" class=" img-thumbnail" src="{{ asset('images/livres').'/'.$livre->image }}" alt=""></td>
                    <td>{{ $livre->titre }}</td>
                    <td>{{ $livre->quantity }}</td>
                    <td>{{ $livre->prix_unitaire }} DH</td>
                    @foreach ($commande as $cmd )
                    <form action="{{ route('produitcmd.delete', [$cmd->id, $livre->id]) }}" method="post">
                        @endforeach
                        @method('delete')
                        @csrf

                    <td><a data-bs-toggle="modal" data-id="{{ $livre->id }}"  data-bs-target="#modelproduits" class="text-white p-1 btn btn-warning editpro"><i class="fas fa-edit"></i></a><button type="submit" class="btn btn-danger p-1 ms-1" ><i class="fas fa-trash"></i></button></td>
                </form>
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
    @foreach ($commande as $cmd )
    <form class="d-flex mb-4" action="{{ route('confirmer.commande', $cmd->id) }}" method="post">
        @csrf
        @method('put')


                <label for="liv" class="form-label mx-3">Séléctionner le livreur</label>
            <select id="liv" class="form-select" name="choixliv" aria-label="Default select example">
                    @foreach ($livreurs as $liv)
                    <option value="{{ $liv->id }}">{{ $liv->nom_societe }}</option>
                    @endforeach


              </select>
              <button type="submit" class="btn btn-success mx-3">Confirmer</button>
    </form>
    <form action="{{ route('annuler.commande', $cmd->id) }}" method="post">
        @csrf
        @method('put')
        <div class="mb-3 d-flex justify-content-center align-items-center">


            <button type="submit" class="btn btn-danger ms-2">Annuler</button>
        </div>
        </form>


        @endforeach

</div>

        </div>



    </div>
</div>

<!--modal pour modifer les informatons de livraison-->
<div class="modal fade" id="modellivraison" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Modifier les information de livraison</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @if ($errors->any() && session()->has('fail'))
                    <div class="alert alert-danger">

                     <ul>
                         @foreach ($errors->all() as $error )
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                    </div>

                    @endif
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        @foreach ($commande as $cmd )
                        <form action="{{ route('detail.update', $cmd->id) }}" method="post" id="formData" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value="{{ $cmd->id }}" id="idcmd">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">Prenom *</label>
                                <input type="text" class="form-control" name="shipprenom" id="firstName" placeholder="" value="{{ $cmd->ship_prenom }}" required>
                                <div class="invalid-feedback">
                                  Valid first name is required.
                                </div>
                              </div>

                              <div class="mb-3">
                                <label for="lastName" class="form-label">Nom *</label>
                                <input type="text" class="form-control" name="shipnom" id="lastName" placeholder="" value="{{ $cmd->ship_nom }}" required>
                                <div class="invalid-feedback">
                                  Valid last name is required.
                                </div>
                              </div>

                              <div class="mb-3">
                                <label for="phone" class="form-label">Numéro de téléphone mobile *</label>
                                <div class="input-group has-validation">
                                  <span class="input-group-text">+212</span>
                                  <input type="text" class="form-control" name="phone" value="{{ $cmd->phone }}" id="phone" required>
                                <div class="invalid-feedback">
                                    Your username is required.
                                  </div>
                                </div>
                              </div>


                              <div class="mb-3">
                                <label for="address" class="form-label">Address *</label>
                                <input type="text" class="form-control" value="{{ $cmd->shipadresse }}" name="adresse" id="address" placeholder="Rue / Appartement / Suite / Bloc / Bâtiment" required>
                                <div class="invalid-feedback">
                                  Please enter your shipping address.
                                </div>
                              </div>

                        <div class="mb-3">
                            <div class="col-md-4">
                                <label for="state" class="form-label">Region *</label>
                                <select name="region" class="form-select selectregion" id="state" required>
                                  <option value="Chaouia-Ouardigha">Chaouia-Ouardigha</option>
                                  <option value="Doukkala-Abda">Doukkala-Abda</option>
                                  <option value="Fès-Boulemane">Fès-Boulemane</option>
                                  <option value="Gharb-Chrarda-Béni Hssen">Gharb-Chrarda-Béni Hssen</option>
                                  <option value="Grand Casablanca">Grand-Casablanca</option>
                                  <option value="Guelmim-Es Smara">Guelmim-Es-Smara</option>
                                  <option value="Laâyoune-Boujdour-Sakia el Hamra">Laâyoune-Boujdour-Sakia-el-Hamra</option>
                                  <option value="Marrakech-Tensift-Al Haouz">Marrakech-Tensift-Al Haouz</option>
                                  <option value="Meknès-Tafilalet">Meknès-Tafilalet</option>
                                  <option value="Oriental">Oriental</option>
                                  <option value="Oued-Ed-Dahab-Lagouira">Oued-Ed-Dahab-Lagouira</option>
                                  <option value="Rabat-Salé-Zemmour-Zaër">Rabat-Salé-Zemmour-Zaër</option>
                                  <option value="Souss-Massa-Draâ">Souss-Massa-Draâ</option>
                                  <option value="Tadla-Azilal">Tadla-Azilal</option>
                                  <option value="Tanger-Tétouan">Tanger-Tétouan</option>
                                  <option value="Taza-Al-Hoceïma-Taounate">Taza-Al-Hoceïma-Taounate</option>
                                </select>
                                <div class="invalid-feedback">
                                  Please provide a valid state.
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="state" class="form-label">Ville *</label>
                                <select name="ville" class="form-select selectville" id="state" required>
                                    <option value="Casablanca"> Casablanca</option>
                                    <option value="Agadir"> Agadir</option>
                                    <option value="Al Hoceima"> Al Hoceima</option>
                                    <option value="Béni Mellal"> Béni Mellal</option>
                                    <option value="El Jadida"> El Jadida</option>
                                    <option value="Errachidia"> Errachidia</option>
                                    <option value="Fès"> Fès</option>
                                    <option value="Kénitra"> Kénitra</option>
                                    <option value="Khénifra"> Khénifra</option>
                                    <option value="Khouribga"> Khouribga</option>
                                    <option value="Larache"> Larache</option>
                                    <option value="Marrakech"> Marrakech</option>
                                    <option value="Meknès"> Meknès</option>
                                    <option value="Nador"> Nador</option>
                                    <option value="Ouarzazate"> Ouarzazate</option>
                                    <option value="Oujda"> Oujda</option>
                                    <option value="Rabat"> Rabat</option>
                                    <option value="Safi"> Safi</option>
                                    <option value="Settat"> Settat</option>
                                    <option value="Salé"> Salé</option>
                                    <option value="Tanger"> Tanger</option>
                                    <option value="Taza"> Taza</option>
                                    <option value="Tétouan"> Tétouan</option>
                                </select>
                                <div class="invalid-feedback">
                                  Please provide a valid state.
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="zip" class="form-label">Zip</label>
                                <input name="zip" type="text" value="{{ $cmd->ship_code_postal }}" class="form-control" id="zip" placeholder="" required>
                                <div class="invalid-feedback">
                                  Zip code required.
                                </div>
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input class="btn btn-outline-primary" type="submit" value="Modifier">
                        </div>

                        </form>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--modal pour modifer les informatons des produits-->


<div class="modal fade" id="modelproduits" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Modifier la quantite de produit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @if ($errors->any() && session()->has('fail'))
                    <div class="alert alert-danger">

                     <ul>
                         @foreach ($errors->all() as $error )
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                    </div>

                    @endif
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <form method="post" id="formMod" enctype="multipart/form-data">
                            @csrf
                        <div class="mb-3">
                          <label for="quantityMod" class="form-label">Quantité :</label>
                          <input type="number" value="" name="quantityMod" id="quantityMod" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input class="btn btn-outline-primary" type="submit" value="Modifier">
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script>


    @foreach ($commande as $cmd )
        var region = "{{ $cmd->ship_region }}"
        var ville = "{{ $cmd->ship_ville }}"

    @endforeach
    var optionregion = document.querySelector('.selectregion').options;

           for(i=0; i<optionregion.length; i++){
               if(optionregion[i].value==region){
               $('.selectregion option[value='+region+']').attr('selected','selected');
               }
           }
     var optionville = document.querySelector('.selectville').options;
           for(i=0; i<optionville.length; i++){
               if(optionville[i].value==ville){
               $('.selectville option[value='+ville+']').attr('selected','selected');
               }
           }
    $(document).ready(function($){
        @if ($errors->any() && session()->has('fail'))
    $('#modellivraison').modal('show');
    @endif
     $('.editpro').click(function(){

         var id = $(this).attr('data-id');
         var idcmd = $('#idcmd').val();
         $('#formMod').attr("action", "/admin/commandes/details/update-produit/"+idcmd+"/"+id);
         $.ajax({
          url: '/admin/commandes/details/edit-produit/'+idcmd+'/'+id,
          type: 'GET',
          dataType: 'JSON',
          success: function(response){
          $('#quantityMod').val(response['quantity']);

          }


         });
     })
    });
</script>
@endsection
