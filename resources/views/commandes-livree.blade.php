@extends('Master.MasterDash')
@section('title')
    liste des commandes
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row my-5">
        <h3 class="fs-4 mb-3">Les Commandes</h3>
        <div class="col">
        @if(session('successdele'))
            <div class="alert alert-success">
                {{ session('successdele') }}
            </div>
            @elseif(session('successAnnuler'))
            <div class="alert alert-success">
                {{ session('successAnnuler') }}
            </div>
            @elseif(session('successConfirmer'))
            <div class="alert alert-success">
                {{ session('successConfirmer') }}
            </div>
        @endif
            <table class="table bg-white rounded shadow-sm  table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="100">#ID</th>
                        <th scope="col">Nom Client</th>
                        <th scope="col">Total Qty</th>
                        <th scope="col">Total Prix</th>
                        <th scope="col">Statue</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commandes as $cmd )
                    @if($cmd->statue == "livrer")
                    <tr>
                        <th scope="row">{{ $cmd->id }}</th>
                        <td>{{ $cmd->nom }}</td>
                        <td>{{ $cmd->totalq }}</td>

                        <td>{{ $cmd->totalr }}DH</td>
                        <td class="text-success fst-italic fw-bold">livée</td>
                        <td class=" position-relative d-flex flex-lg-row"><a href="{{ route('commande.show', $cmd->id) }}" class="btn btn-warning me-1"><i class="fas fa-eye"></i></a>
                            @if (!$cmd->deja_vu)
                            <sup class=" position-absolute badge rounded-pill bg-danger">1</sup>
                            @endif
                            <form action="{{ route('commande.delete', $cmd->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" value="pageconf" name="page">
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>

                        </td>

                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
