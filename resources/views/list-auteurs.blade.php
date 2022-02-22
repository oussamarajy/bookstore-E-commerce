@extends('Master.MasterDash')
@section('title')Liste des categorie @endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row g-3 mt-3">
        <div class="col-md-2">
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modelaut">Ajouter un auteur</a>
        </div>
        <div class="col-md-5 d-inline-flex">
            <form action="{{ route('auteur.search') }}" class="d-flex flex-lg-row">
<input class=" form-control me-1" placeholder="Entrer ID, Titre..." type="text" name="search" id="">
<input class="btn btn-outline-dark" type="submit" value="Rechercher">
</form>
    </div>

    <div class="row my-5">
        <h3 class="fs-4 mb-3">Les Auteurs</h3>

        @if (session()->has('successMod'))
           <div class="alert alert-success">
               {{ session()->get('successMod') }}
        </div>
        @elseif (session()->has('successDel'))
           <div class="alert alert-success">
               {{ session()->get('successDel') }}
        </div>
        @elseif (session()->has('successAjo'))
           <div class="alert alert-success">
               {{ session()->get('successAjo') }}
        </div>
        @endif

        <div class="col">
            <table class="table bg-white rounded shadow-sm  table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col" width="50">#ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Nom</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if ($auteurs->count()>= 1)


                    @foreach ($auteurs as $auteur)
                    <tr>
                        <th scope="row">{{ $auteur->id }}</th>
                        <td><img width="100" class=" img-fluid border border-info border-3" src="{{asset('images/auteurs').'/'.$auteur->image }}" alt=""></td>
                        <td>{{ $auteur->nom }}</td>
                        <td>
                            <form action="{{ route('auteur.delete', $auteur->id) }}" method="post">
                                @csrf
                                @method('delete')
                            <a href="{{ route('auteur.show', [$auteur->id, $auteur->slug]) }}" class="btn btn-warning me-1"><i class="fas fa-eye"></i></a><a data-bs-toggle="modal" data-bs-target="#modelautMod" data-id="{{ $auteur->id }}" class="btn btn-info me-1 edit"><i class="fas fa-pen"></i></a><button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4">
                    <div class="row text-center">

                        <h4 class="text-secondary p-2">Aucun résultat.</h4>

                 </div>
                </td>
                </tr>
                 @endif


                </tbody>
            </table>
        </div>
        {{ $auteurs->links() }}
    </div>

</div>
</div>
</div>
<!-- /#page-content-wrapper -->
</div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="modelaut" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Ajouter un auteur</h5>
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
                        <form action="{{ route('auteur.store') }}" method="post" id="formData" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="Nom" class="form-label">Nom de l'auteur</label>
                                <input type="text" name="nomauteur" id="Nom" class="form-control" placeholder="Nom Complet">
                              </div>
                              <div class="mb-3">
                                  <label for="bio" class="form-label">Bio</label>
                                 <textarea class=" form-control" name="bio" id="bio" cols="30" rows="10"></textarea>
                                </div>

                                <div class="mb-3">
                                  <label for="image" class="form-label">Ajouter une Image</label>
                                  <input type="file" name="imagefile" class="form-control" id="image">

                                </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input class="btn btn-outline-primary" type="submit" value="Ajouter">
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var modelId = document.getElementById('modelaut');

    modelId.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          let button = event.relatedTarget;
          // Extract info from data-bs-* attributes
          let recipient = button.getAttribute('data-bs-whatever');

        // Use above variables to manipulate the DOM
    });



</script>
<!-- Modal Modfier-->
<div class="modal fade" id="modelautMod" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                        <form  method="post" id="formMod" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="Nom" class="form-label">Nom de l'auteur</label>
                                <input type="text" value="" name="nomauteur" id="NomMod" class="form-control" placeholder="Nom Complet">
                              </div>
                              <div class="mb-3">
                                  <label for="bio" class="form-label">Bio</label>
                                 <textarea class=" form-control" value="" name="bio" id="bioMod" cols="30" rows="10"></textarea>
                                </div>

                                <div class="mb-3">
                                  <label for="image" class="form-label">Ajouter une Image</label>
                                  <input type="file" name="imagefile" class="form-control" id="imageMod">
                                  <img class=" img-fluid mt-1" id="showimg" width="70" src="" alt="old img">

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

    var modelIdy = document.getElementById('modelautMod');

    modelIdy.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          let button = event.relatedTarget;
          // Extract info from data-bs-* attributes
          let recipient = button.getAttribute('data-bs-whatever');

        // Use above variables to manipulate the DOM
    });



</script>
<script type="text/javascript">
    $(document).ready(function($){

        @if ($errors->any() && session()->has('failmod'))

        $('#modelautMod').modal('show');
        $('Nom').val({{ session()->get('idaut') }});
        $('#formMod').attr("action", "modifier-auteur/"+{{ session()->get('idaut') }});
        $.ajax({
          url: 'edit-auteur/'+{{ session()->get('idaut') }},
          type: 'GET',
          dataType: 'JSON',
          success: function(response){

            $('#NomMod').val(response['nom']);
              $('#bioMod').val(response['bio']);
              $('#imageMod').attr('value', '/images/auteurs/'+response['image']);
              $('#showimg').attr('src', '/images/auteurs/'+response['image']);


          }

        });
        @elseif ($errors->any() && session()->has('fail'))
        $('#modelaut').modal('show');
        @endif



    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.edit').click(function(){
        var id = $(this).attr('data-id');
        $('#formMod').attr("action", "modifier-auteur/"+id);
        $.ajax({
          url: 'edit-auteur/'+id,
          type: 'GET',
          dataType: 'JSON',
          success: function(response){
              console.log(response['nom']);

            $('#NomMod').val(response['nom']);
              $('#bioMod').val(response['bio']);
              $('#imageMod').attr('value', '/images/auteurs/'+response['image']);
              $('#showimg').attr('src', '/images/auteurs/'+response['image']);

          }

        });
    });
});
</script>
@endsection
