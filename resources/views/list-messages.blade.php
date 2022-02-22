@extends('Master.MasterDash')
@section('title')
    liste des Messages
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row my-5">
        <h3 class="fs-4 mb-3">Les Messages</h3>
        @if (session('success'))
        <h4 class="text-small text-center text-success mt-3 bg-white">{{ session('success') }}</h4>
        @endif
        <div class="col">
            <table class="table bg-white rounded shadow-sm  table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="100">#ID</th>
                        <th scope="col">Nom Complet</th>
                        <th scope="col">Email</th>
                        <th scope="col">Statue</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $msg)
                    <tr>
                        <th scope="row">{{ $msg->id }}</th>
                        <td>{{ $msg->nom }}</td>
                        <td>{{ $msg->email }}</td>
                        <td>@if($msg->statue)
                                <b class="text-success">déjà répondu</b>
                            @else
                            <b class="text-danger">il est encore</b>
                            @endif
                        </td>
                        <form action="{{ route('message.delete', $msg->id) }}" method="post">
                            @csrf
                            @method('delete')
                        <td><a data-bs-toggle="modal" data-id="{{ $msg->id }}" data-bs-target="#modelId" class="btn btn-warning text-white me-2 btnshow"><i class="fas fa-eye"></i></a><button type="submit" class="btn btn-danger text-white"><i class="fas fa-trash"></i></button></td>
                    </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $messages->links() }}
    </div>
</div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Le message </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <ul id="contenuMsg">

             </ul>
             <form action="{{ route('rep.admin') }}" method="post">
                @csrf
                <input type="hidden" class="form-control" id="inputidclient" name="idclient">
                <input type="hidden" class="form-control" id="inputidmsg" name="idmsg">
                <input type="hidden" class="form-control" id="inputtitre" name="titre">
                 <div class="mb-3">
                   <label for="rep" class="form-label">La reponse :</label>
                   <textarea class="form-control" name="message" id="rep" rows="5"></textarea>
                 </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function($){

        $('.btnshow').click(function(){
            var id = $(this).attr('data-id');
            $('#contenuMsg').empty();
            $.ajax({
                url:  "show-message/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(response){

                    $('#contenuMsg').append('<li><b class="text-primary">De :</b> '+response[0]['nom']+'</li>');
                    $('#contenuMsg').append('<li class="mt-1"><b class="text-primary">Titre :</b>'+response[0]['titre']+'</li>');
                    $('#contenuMsg').append('<li class="mt-1"><b class="text-primary">Message :</b> '+response[0]['contenu']+'</li>');
                    $('#inputidclient').attr("value", response[0]['from_id']);
                    $('#inputidmsg').attr("value", response[0]['id']);
                    $('#inputtitre').attr("value", response[0]['titre']);


                }
        });
        });

    });
</script>
@endsection
