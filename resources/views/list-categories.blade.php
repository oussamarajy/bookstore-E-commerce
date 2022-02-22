@extends('Master.MasterDash')
@section('title')Liste des categorie @endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row g-3 mt-3">
        <div class="col-md-2">
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modelcat">Ajouter une Catégorie</a>
        </div>
        <div class="col-md-5 d-inline-flex">
            <form action="{{ route('categorie.search') }}" class="d-flex flex-lg-row">
<input class=" form-control me-1" placeholder="Entrer ID, Titre..." type="text" name="search" id="">
<input class="btn btn-outline-dark" type="submit" value="Rechercher">
</form>
    </div>

    <div class="row my-5">
        <h3 class="fs-4 mb-3">Les Catégories</h3>

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
                        <th scope="col">Titre</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
@if ($categories->count() >= 1)


                    @foreach ($categories as $categorie)
                    <tr>
                        <th scope="row">{{ $categorie->id }}</th>
                        <td><img width="100" class=" img-fluid border border-info border-3" src="{{asset('images/categories').'/'.$categorie->image }}" alt=""></td>
                        <td>{{ $categorie->titre_cat }}</td>
                        <td>
                            <form action="{{ route('categorie.delete', $categorie->id) }}" method="post">
                                @csrf
                                @method('delete')
                            <a href="{{ route('categorie.show', [$categorie->id, $categorie->slug_cat]) }}" class="btn btn-warning me-1"><i class="fas fa-eye"></i></a><a data-bs-toggle="modal" data-bs-target="#modelcatMod" data-id="{{ $categorie->id }}" class="btn btn-info me-1 edit"><i class="fas fa-pen"></i></a><button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
        {{ $categories->links() }}
    </div>

</div>
</div>
</div>
<!-- /#page-content-wrapper -->
</div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="modelcat" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Ajouter une catégorie</h5>
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
                        <form action="{{ route('categorie.store') }}" method="post" id="formData" enctype="multipart/form-data">
                            @csrf
                        <div class="mb-3">
                          <label for="titrecat" class="form-label">Title</label>
                          <input type="text" value="" name="titrecat" id="titrecat" class="form-control" placeholder="Titre de Catégorie">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="desc">Description</label>
                            <textarea  class="form-control" value="" name="description" placeholder="Description" id="desc" cols="30" rows="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="img">Ajouter une image</label>
                            <input class="form-control" value="" type="file" name="image" id="img">
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
    var modelId = document.getElementById('modelcat');

    modelId.addEventListener('show.bs.modal', function (event) {
          // Button that triggered the modal
          let button = event.relatedTarget;
          // Extract info from data-bs-* attributes
          let recipient = button.getAttribute('data-bs-whatever');

        // Use above variables to manipulate the DOM
    });



</script>
<!-- Modal Modfier-->
<div class="modal fade" id="modelcatMod" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                          <label for="titrecat" class="form-label">Title</label>
                          <input type="text" value="" name="titrecat" id="titrecatMod" class="form-control" placeholder="Titre de Catégorie">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="desc">Description</label>
                            <textarea  class="form-control" value="" name="description" placeholder="Description" id="descMod" cols="30" rows="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="img">Modifier l'image</label>
                            <input class="form-control" value="" type="file" name="image" id="imgMod">
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

    var modelIdy = document.getElementById('modelcatMod');

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

        $('#modelcatMod').modal('show');
        $('#titrecatMod').val({{ session()->get('idcat') }});
        $('#formMod').attr("action", "modifier-categorie/"+{{ session()->get('idcat') }});
        $.ajax({
          url: 'edit-categorie/'+{{ session()->get('idcat') }},
          type: 'GET',
          dataType: 'JSON',
          success: function(response){

              $('#titrecatMod').val(response['titre_cat']);
              $('#descMod').val(response['Description']);
              $('#imgMod').attr('value', '/images/categories/'+response['image']);
              $('#showimg').attr('src', '/images/categories/'+response['image']);


          }

        });
        @elseif ($errors->any() && session()->has('fail'))
        $('#modelcat').modal('show');
        @endif



    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.edit').click(function(){
        var id = $(this).attr('data-id');
        $('#formMod').attr("action", "modifier-categorie/"+id);
        $.ajax({
          url: 'edit-categorie/'+id,
          type: 'GET',
          dataType: 'JSON',
          success: function(response){

              $('#titrecatMod').val(response['titre_cat']);
              $('#descMod').val(response['Description']);
              $('#imgMod').attr('value', '/images/categories/'+response['image']);
              $('#showimg').attr('src', '/images/categories/'+response['image']);


          }

        });
    });
});
</script>
@endsection
