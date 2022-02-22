@extends('Master.MasterHome')
@section('title')
    Contactez-nous
@endsection

@section('content')
<h3 class="text-small text-center mt-3">Comment pouvons-nous vous aider ?</h3>

    @if (session('success'))
    <h4 class="text-small text-center text-success mt-3">{{ session('success') }}</h4>

    @elseif ($errors->any())
    <div class="alert alert-danger">

     <ul>
         @foreach ($errors->all() as $error )
             <li>{{ $error }}</li>
         @endforeach
     </ul>
    </div>

    @endif



<div class="card w-75 m-auto">
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('send') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        @if (Auth::check())
                        <input type="email" class="form-control" name="email" id="" value="{{ Auth::user()->email }}" aria-describedby="helpId" placeholder="E-mail">
                        @else
                        <input type="email" class="form-control" name="email" id="" aria-describedby="helpId" placeholder="E-mail">
                        @endif


                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Titre</label>
                        <input type="text" class="form-control" name="titre" id="" aria-describedby="helpId" placeholder="titre">

                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Message</label>
                        <textarea placeholder="Comment pouvons-nous vous aider ?" class="form-control" name="message" id="" rows="3"></textarea>
                      </div>
                      <button type="submit" class="btn btn-dark">Submit</button>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection
