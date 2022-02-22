@extends('Master.MasterDash')
@section('title')
    Liste des livreurs
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row g-3 mt-3">
        <div class="col-md-2">
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modellivreur">Ajouter un livreur</a>
        </div>
        <div class="col-md-5 d-inline-flex">
            <form action="{{ route('livreur.search') }}" class="d-flex flex-lg-row">
<input class=" form-control me-1" placeholder="Entrer ID, nom..." type="text" name="search" id="">
<input class="btn btn-outline-dark" type="submit" value="Rechercher">
            </form>
        </div>
    </div>
    <div class="row my-5">
        <h3 class="fs-4 mb-3">Les Livreurs</h3>
        <div class="col">
        @if(session('successdel'))
            <div class="alert alert-success">
                {{ session('successdel') }}
            </div>
        @elseif (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <table class="table bg-white rounded shadow-sm  table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="100">#ID</th>
                        <th scope="col">Nom Societe</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($livreurs->count() >= 1)


                    @foreach ($livreurs as $liv )
                    <tr>
                        <th scope="row">{{ $liv->id }}</th>
                        <td>{{ $liv->nom_societe }}</td>
                        <td>{{ $liv->phone }}</td>
                        <td class=" position-relative">
                            <form action="{{ route('livreur.supprimer', $liv->id) }}" method="post">
                                @csrf
                                @method('delete')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>

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
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modellivreur" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Ajouter un livreur</h5>
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
                        <form action="{{ route('livreur.ajouter') }}" method="post" id="formData" enctype="multipart/form-data">
                            @csrf
                        <div class="mb-3">
                          <label for="nomS" class="form-label">Nom de société</label>
                          <input type="text" value="" name="nomS" id="nomS" class="form-control" placeholder="Nom de société">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="text"  class="form-control" value="" name="phone" placeholder="06.. ou 07... ou .." id="phone" cols="30" rows="10">
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

<script>
    @if (session('fail'))
    $(document).ready(function($){
        $('#modellivreur').modal('show');
    })

    @endif
</script>
@endsection
