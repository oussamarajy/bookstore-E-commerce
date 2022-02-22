@extends('Master.MasterDash');
@section('title')
   Les Parameters
@endsection
@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-4">
        <div class="list-group" id="myList" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list" data-toggle="list" href="#profile" role="tab">Liste des promotions</a>
            <a class="list-group-item list-group-item-action" id="formajouter" data-toggle="list" href="#home" role="tab">Ajouter une promotion</a>


          </div>
    </div>
    <div class="col-lg-7">
        <div class="tab-content">
          <div class="tab-pane active" id="profile" role="tabpanel">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('successDel'))
            <div class="alert alert-success">
                {{ session('successDel') }}
            </div>
            @endif
            @if (session()->has('successMod'))
            <div class="alert alert-success">
                {{ session()->get('successMod') }}
         </div>
         @endif
            <table class="table bg-white rounded shadow-sm  table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col" width="50">#ID</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Réduction</th>
                        <th>Date de creation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
@if ($promotions->count() >= 1)


                    @foreach ($promotions as $promotion)
                    <tr>
                        <th scope="row">{{ $promotion->id }}</th>
                        <td>{{ $promotion->titre }}</td>
                        <td>{{ $promotion->reduction }}</td>
                        <td>{{ $promotion->created_at }}</td>
                        <td>
                            <form action="{{ route('promo.supprimer', $promotion->id) }}" method="post">
                                @csrf
                                @method('delete')
                            <a data-bs-toggle="modal" data-bs-target="#ModalPromo" data-id="{{ $promotion->id }}" class="btn btn-info me-1 edit"><i class="fas fa-pen"></i></a><button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
            <div class="tab-pane text-center" id="home" role="tabpanel">

                @if (session()->has('success'))
                <div class="alert alert-success">
                      {{ session()->get('success') }}
                </div>
                 @elseif ($errors->any() && session()->has('fail'))
                    <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error )
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>

                @endif
                <form method="post" action="{{ route('promo.ajouter') }}">
                    @csrf
             <div class="mb-3">
               <label for="" class="form-label"></label>
               <select class="form-control" name="choixLivre" id="">
                   @foreach ( $livres as $livre)
                   <option value="{{ $livre->id }}">{{ $livre->titre }}</option>
                   @endforeach

               </select>
             </div>

             <div class="mb-3">
                 <input class=" form-control" type="number" placeholder="Taux de réduction" name="taux" id="taux">
             </div>

             <div class="mb-3">
<textarea name="citation" placeholder="Citation du livre" class=" form-control" id="" cols="30" rows="10"></textarea>
             </div>
             <div class="mb-3">
                 <div class="form-check">
                   <input type="checkbox" class="form-check-input" name="affichage" id="" value="1">
                   <label class="form-check-label bg-white" for="">
                     Afficher la promotion
                   </label>
                 </div>
             </div>
             <div class="mb-3">
                 <input class="form-control btn btn-primary" type="submit" value="Ajouter">
             </div>
            </form>

          </div>
    </div>
  </div>

</div>


  <script>
      $('#myList a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})


$('#myList a:first-child').tab('show') // Select first tab
$('#myList a[href="#profile"]').tab('show') // Select tab by name

$('#myList a:last-child').tab('show') // Select last tab
$('#myList a:nth-child(3)').tab('show') // Select third tab
  </script>


<!-- Modal -->
<div class="modal fade" id="ModalPromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       @if ($errors->any() && session()->has('failmod'))
                    <div class="alert alert-danger">

                     <ul>
                         @foreach ($errors->all() as $error )
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                     @endif

      <div class="modal-body">
        <form method="post" id="formMod" action="{{ route('promo.ajouter') }}">
            @csrf


     <div class="mb-3">
         <input class=" form-control" type="number" placeholder="Taux de réduction" name="tauxMod" id="tauxMod">
     </div>

     <div class="mb-3">
<textarea name="citationMod" placeholder="Citation du livre" class=" form-control" id="citationMod" cols="30" rows="10"></textarea>
     </div>
     <div class="mb-3">
         <div class="form-check">
           <input type="checkbox" class="form-check-input" name="affichageMod" id="affichageMod" value="1">
           <label class="form-check-label bg-white" for="">
             Afficher la promotion
           </label>
         </div>
     </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" value="Modifier" type="button" class="btn btn-primary">
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function($){

        @if ($errors->any() && session()->has('failmod'))

        $('#ModalPromo').modal('show');
        $('#formMod').attr("action", "modifier-promo/"+{{ session()->get('idpromo') }});
        $.ajax({
          url: 'edit-promo/'+{{ session()->get('idpromo') }},
          type: 'GET',
          dataType: 'JSON',
          success: function(response){

              $('#tauxMod').val(response['reduction']);
              $('#citationMod').val(response['citation']);
              if(response['affichage']==1){
              $('#affichageMod').attr('checked', 'checked');
              }



          }

        });
        @elseif ($errors->any() && session()->has('fail'))
        $('#myList a[href="#home"]').tab('show')
        @endif



    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.edit').click(function(){
        var id = $(this).attr('data-id');
        $('#formMod').attr("action", "modifier-promo/"+id);
        $.ajax({
          url: 'edit-promo/'+id,
          type: 'GET',
          dataType: 'JSON',
          success: function(response){

              $('#tauxMod').val(response['reduction']);
              $('#citationMod').val(response['citation']);
              if(response['affichage']==1){
              $('#affichageMod').attr('checked', 'checked');
              }



          }

        });
    });
});
</script>
@endsection
