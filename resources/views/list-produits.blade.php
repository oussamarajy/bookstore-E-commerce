@extends('Master.MasterDash')
@section('content')
@section('title')
    Liste des produits
@endsection
<div class="container-fluid px-4">
    <div class="row g-3 mt-3">
        <div class="col-md-2">
            <a class="btn btn-primary ajouter" href="list-produits/ajouter" data-bs-toggle="modal">Ajouter un produit</a>
        </div>
        <div class="col-md-5 d-inline-flex">
            <form action="{{ route('livre.search') }}" class="d-flex flex-lg-row">
<input class=" form-control me-1" placeholder="Entrer ID, Titre..." type="text" name="search" id="">
<input class="btn btn-outline-dark" type="submit" value="Rechercher">
            </form>
    </div>

    <div class="row my-5">
        <h3 class="fs-4 mb-3">Les Produits</h3>
        @if (session()->has('successAjou'))
        <div class="alert alert-success">
             {{ session()->get('successAjou') }}
        </div>
@elseif (session()->has('successDel'))
<div class="alert alert-success">
{{ session()->get('successDel') }}
</div>
        @endif
        <div class="col">
            <table class="table bg-white rounded shadow-sm  table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col" width="50">#ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($livres as $livre)


                    <tr>
                        <th scope="row">{{ $livre->id }}</th>
                        <td><img width="100" class=" img-fluid border border-info border-3" src="{{ asset('images/livres').'/'.$livre->image }}" alt=""></td>
                        <td>{{ $livre->titre }}</td>
                        <td>{{ $livre->prix }} DH</td>
                        <td>
                            <form action="{{ route('livre.delete', $livre->id) }}" method="post">
                                @csrf
                                @method('delete')
                            <a href="{{ route('livre.show', [$livre->id, $livre->slug]) }}" class="btn btn-warning me-1"><i class="fas fa-eye"></i></a><a data-bs-toggle="modal" data-bs-target="#modelProduitMod" data-id="{{ $livre->id }}" class="btn btn-info me-1 edit"><i class="fas fa-pen"></i></a><button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>

            {{ $livres->links() }}


    </div>

</div>
</div>
</div>
<!-- /#page-content-wrapper -->
</div>
<!-- Button trigger modal -->


<!-- Modal ajouter -->
<div class="modal fade" id="modelProduit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Ajouter un Auteur</h5>
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
                        <h3>Ajouter les détails</h3>

                <form action="{{ route('livre.store') }}" method="post" id="formData" enctype="multipart/form-data">
                            @csrf
                    <div class="mb-3">
                        <label for="cat" class="form-label">Categories</label>
                        <select class="form-control select1" name="categorie" id="cat">

                        </select>
                      </div>


                      <div class="mb-3">
                        <label for="auteur" class="form-label">L'auteur</label>
                        <select class="form-control select2" name="auteur" id="auteur">


                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input placeholder="ISBN" type="text" name="isbn" class="form-control" id="isbn">

                      </div>
                      <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input placeholder="Titre" type="text" name="titre" class="form-control" id="titre">

                      </div>
                      <div class="mb-3">
                        <label for="nb" class="form-label">Nombre de Pages</label>
                        <input placeholder="Nombre de Pages" type="text" name="nbpages" class="form-control" id="nb">

                      </div>
                      <div class="mb-3">
                        <label for="nb" class="form-label">Date de publication</label>
                        <input placeholder="La date de publication" type="date" name="date" class="form-control" id="date">

                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Prix</label>
                        <input placeholder="Prix" type="text" name="prix" class="form-control" id="">

                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Quantité</label>
                        <input placeholder="Quantity" type="text" name="quantity" class="form-control" id="">

                      </div>

                      <div class="mb-3">
                        <label for="nb" class="form-label">Plus d'informations</label>
                        <textarea placeholder="Description de livre.." type="text" name="description" class="form-control" id="desc"></textarea>

                      </div>
                      <div class="mb-3">
                        <label for="image" class="form-label">Ajouter une Image</label>
                        <input type="file" name="imagefile" class="form-control" id="image">

                      </div>

                    <button type="submit" class="btn btn-dark px-5">Ajouter</button>
                  </form>
                    </div>
                </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var modelProduit = document.getElementById('modelProduit');
    modelProduit.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          let button = event.relatedTarget;
          // Extract info from data-bs-* attributes
          let recipient = button.getAttribute('data-bs-whatever');

        // Use above variables to manipulate the DOM
    });

</script>
<!-- Modal Modification -->
<div class="modal fade" id="modelProduitMod" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
              <div class="modal-header">
                      <h5 class="modal-title">Modification</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  @if ($errors->any() && session()->has('failmod'))
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
                      <h3>Modifier les détails</h3>

              <form method="post" id="formMod" enctype="multipart/form-data">
                          @csrf
                  <div class="mb-3">
                      <label for="categorieMod" class="form-label">Categories</label>
                      <select class="form-control select1Mod" name="categorie" id="categorieMod">

                      </select>
                    </div>


                    <div class="mb-3">
                      <label for="auteurMod" class="form-label">L'auteur</label>
                      <select class="form-control select2Mod" name="auteur" id="auteurMod">


                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="isbnMod" class="form-label">ISBN</label>
                      <input placeholder="ISBN" type="text" name="isbn" class="form-control" id="isbnMod">

                    </div>
                    <div class="mb-3">
                      <label for="titreMod" class="form-label">Titre</label>
                      <input placeholder="Titre" type="text" name="titre" class="form-control" id="titreMod">

                    </div>
                    <div class="mb-3">
                      <label for="nbpagesMod" class="form-label">Nombre de Pages</label>
                      <input placeholder="Nombre de Pages" type="text" name="nbpages" class="form-control" id="nbpagesMod">

                    </div>
                    <div class="mb-3">
                      <label for="dateMod" class="form-label">Date de publication</label>
                      <input placeholder="La date de publication" type="date" name="date" class="form-control" id="dateMod">

                    </div>
                    <div class="mb-3">
                      <label for="prixMod" class="form-label">Prix</label>
                      <input placeholder="Prix" type="text" name="prix" class="form-control" id="prixMod">

                    </div>
                    <div class="mb-3">
                      <label for="quantityMod" class="form-label">Quantité</label>
                      <input placeholder="Quantity" type="text" name="quantity" class="form-control" id="quantityMod">

                    </div>

                    <div class="mb-3">
                      <label for="descMod" class="form-label">Plus d'informations</label>
                      <textarea placeholder="Description de livre.." type="text" name="description" class="form-control" id="descMod"></textarea>

                    </div>
                    <div class="mb-3">
                      <label for="imageMod" class="form-label">Ajouter une Image</label>
                      <input type="file" name="imagefile" class="form-control" id="imageMod">
                      <img class=" img-fluid mt-1" id="showimg" width="70" src="" alt="old img">

                    </div>

                  <button type="submit" class="btn btn-dark px-5">Modifier</button>
                </form>
                  </div>
              </div>
                  </div>
              </div>
          </div>

      </div>
  </div>
</div>
<script>
  var modelProduit = document.getElementById('modelProduit');
  modelProduit.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        let button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        let recipient = button.getAttribute('data-bs-whatever');

      // Use above variables to manipulate the DOM
  });

</script>
<script>
    $(document).ready(function($){
//
@if ($errors->any() && session()->has('failmod'))

        $('#modelProduitMod').modal('show');
        $.ajax({
          url: 'prepare-livre',
          type: 'GET',
          dataType: 'JSON',
          success: function(response2){

           var dataCategories = "";
           var dataAuteurs = "";
          $.each(response2, function(key, value){
            if(value.id != undefined && value.titre_cat != undefined){
                dataCategories += '<option value="'+value.id+'">'+value.titre_cat+'</option>';
            }
          });
          $.each(response2, function(key, value){
            if(value.id != undefined && value.nom != undefined){
                dataAuteurs += '<option value="'+value.id+'">'+value.nom+'</option>';
            }
          });
          $('.select1Mod').html(dataCategories)
          $('.select2Mod').html(dataAuteurs)
          }
          });

    $('#formMod').attr('action', 'modifier-livre/'+{{ session()->get('idlivre'); }});
     $.ajax({
       url: 'edit-livre/'+{{ session()->get('idlivre'); }},
       type: 'GET',
       dataType: 'JSON',
       success: function(response){
        $('#isbnMod').val(response['isbn']);
           $('#nbpagesMod').val(response['nb_pages']);
           $('#titreMod').val(response['titre']);
           $('#dateMod').val(response['date_pub']);
           $('#prixMod').val(response['prix']);
           $('#quantityMod').val(response['quantity']);
           $('#descMod').val(response['description']);
           $('#showimg').attr('src', '/images/livres/'+response['image']);
           var optionCat = document.querySelector('.select1Mod').options;
           for(i=0; i<optionCat.length; i++){
               if(optionCat[i].value==response['categorie_id']){
               $('.select1Mod option[value='+response['categorie_id']+']').attr('selected','selected');
               }
           }
           var optionAut = document.querySelector('.select2Mod').options;
           for(i=0; i<optionAut.length; i++){
               if(optionAut[i].value==response['auteur_id']){
               $('.select2Mod option[value='+response['auteur_id']+']').attr('selected','selected');
               }
           }


       }

     });
        @elseif ($errors->any() && session()->has('fail'))
        $('#modelProduit').modal('show');
        @endif

        // preprer les donnee de cat et aut
$('.edit').click(function(){
    $.ajax({
          url: 'prepare-livre',
          type: 'GET',
          dataType: 'JSON',
          success: function(response2){

           var dataCategories = "";
           var dataAuteurs = "";
          $.each(response2, function(key, value){
            if(value.id != undefined && value.titre_cat != undefined){
                dataCategories += '<option value="'+value.id+'">'+value.titre_cat+'</option>';
            }
          });
          $.each(response2, function(key, value){
            if(value.id != undefined && value.nom != undefined){
                dataAuteurs += '<option value="'+value.id+'">'+value.nom+'</option>';
            }
          });
          $('.select1Mod').html(dataCategories)
          $('.select2Mod').html(dataAuteurs)
          }
          });
    var id = $(this).attr('data-id');
    $('#formMod').attr('action', 'modifier-livre/'+id);
     $.ajax({
       url: 'edit-livre/'+id,
       type: 'GET',
       dataType: 'JSON',
       success: function(response){
        $('#isbnMod').val(response['isbn']);
           $('#nbpagesMod').val(response['nb_pages']);
           $('#titreMod').val(response['titre']);
           $('#dateMod').val(response['date_pub']);
           $('#prixMod').val(response['prix']);
           $('#quantityMod').val(response['quantity']);
           $('#descMod').val(response['description']);
           $('#showimg').attr('src', '/images/livres/'+response['image']);
           var optionCat = document.querySelector('.select1Mod').options;
           for(i=0; i<optionCat.length; i++){
               if(optionCat[i].value==response['categorie_id']){
               $('.select1Mod option[value='+response['categorie_id']+']').attr('selected','selected');
               }
           }
           var optionAut = document.querySelector('.select2Mod').options;
           for(i=0; i<optionAut.length; i++){
               if(optionAut[i].value==response['auteur_id']){
               $('.select2Mod option[value='+response['auteur_id']+']').attr('selected','selected');
               }
           }


       }

     });
});




// ajax recuperer les donner de la table categories et auteurs
     $('.ajouter').click(function(){
        $.ajax({
          url: 'prepare-livre',
          type: 'GET',
          dataType: 'JSON',
          success: function(response){

           var dataCategories = "";
           var dataAuteurs = "";
          $.each(response, function(key, value){
            if(value.id != undefined && value.titre_cat != undefined){
                dataCategories += '<option value="'+value.id+'">'+value.titre_cat+'</option>';
            }
          });
          $.each(response, function(key, value){
            if(value.id != undefined && value.nom != undefined){
                dataAuteurs += '<option value="'+value.id+'">'+value.nom+'</option>';
            }
          });
          $('.select1').html(dataCategories)
          $('.select2').html(dataAuteurs)


          if(dataAuteurs=="" || dataCategories ==""){
        Swal.fire(
            'Pour ajouter un Livre!',
            'Il faut ajouter au moins une categorie et un auteur!',
            'error'
            )

          }
          else{
            $("#modelProduit").modal('show');
          }



          }

        });
    });
    });
</script>
@endsection
