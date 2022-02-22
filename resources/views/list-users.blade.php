@extends('Master.MasterDash')
@section('title')
    Liste des utilisateurs
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row g-3 mt-3">
        <div class="col-md-2">
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modeluser">Ajouter User</a>
        </div>
        <div class="col-md-5 d-inline-flex">
            <form action="{{ route('usersAdmin.search') }}" class="d-flex flex-lg-row">
<input class=" form-control me-1" placeholder="Entrer ID, nom..." type="text" name="search" id="">
<input class="btn btn-outline-dark" type="submit" value="Rechercher">
</form>
    </div>
    <div class="row my-5">
        <h3 class="fs-4 mb-3">Les Utilisateurs</h3>
        <div class="col">
        @if(session('successMake'))
            <div class="alert alert-success">
                {{ session('successMake') }}
            </div>
        @elseif(session('successdelAdmin'))
        <div class="alert alert-success">
            {{ session('successdelAdmin') }}
        </div>
        @elseif(session('successdelUser'))
        <div class="alert alert-success">
            {{ session('successdelUser') }}
        </div>
        @endif

            <table class="table table-responsive bg-white rounded shadow-sm  table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="100">#ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Date inscription</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user )
                    <tr @if ($user->id == Auth::user()->id)
                        style="background-color: antiquewhite"
                    @endif>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->nom }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td class=" position-relative d-flex">

                            @if(!$user->isAdmin)
                            <form method="post" action="{{ route('make.admin', $user->id) }}">
                                @csrf
                                @method('put')
                            <button type="submit" class="btn btn-primary text-white text-uppercase makeAdmin me-2">devenir administrateur</button>
                            </form>
                            <form method="post" action="{{ route('remove.user', $user->id) }}">
                                @csrf
                                @method('delete')
                            <button type="submit"  class="btn btn-danger text-white removeUser"><i class="fas fa-trash"></i></button>
                            </form>

                            @else
                            <form method="post" action="{{ route('remove.admin', $user->id) }}">
                                @csrf
                                @method('put')
                            <button type="submit" class="btn btn-danger text-white text-uppercase removeAdmin">Supprimer administrateur</button>
                            </form>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
            {{ $users->links() }}
    </div>
</div>
<!--Model ajouter-->
<div class="modal fade" id="modeluser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajouter User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @if ($errors->any())
          <ul>
            <div class="alert alert-danger">
          @foreach ($errors->all() as $error)

              <li>{{ $error }}</li>


          @endforeach
            </div>
        </ul>
          @endif
        <div class="modal-body">


            <form method="POST" action="{{ route('user-ajouter') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Nom complet</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                    <div class="col-md-6">
                        <input id="phone" type="text" placeholder="0612345678" class="form-control @error('name') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 ms-5">
                        <div class="form-check">
                            <input class="form-check-input" name="checkadmin" type="checkbox" id="checkadmin">
                            <label class="form-check-label" for="checkadmin">
                              Ajouter comme un admin ?
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de Passe') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmer mot de passe') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>







        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">{{ __('Ajouter') }}</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <script>
      @if (session('fail'))
      $(document).ready(function($){
          $('#modeluser').modal('show');
      })

      @endif
  </script>
@endsection
