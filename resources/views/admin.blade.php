@extends('Master.MasterDash')
@section('title')
    Admin
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row g-3 my-2">
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                    <h3 class="fs-2">{{ $livres->count() }}</h3>
                    <p class="fs-5">Produits</p>
                </div>
                <i class="fas fa-gift fs-1 primary-text"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                    <h3 class="fs-2">{{ $commandes->count() }}</h3>
                    <p class="fs-5">Commandes</p>
                </div>
                <i class="fas fa-truck fs-1 primary-text"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                <div>
                    <h3 class="fs-2">{{ $users->count() }}</h3>
                    <p class="fs-5">Utilisateurs</p>
                </div>
                <i class="fas fa-user fs-1 primary-text"></i>
            </div>
        </div>
    </div>



</div>
</div>
</div>
<!-- /#page-content-wrapper -->
</div>

@endsection
