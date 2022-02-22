@extends('Master.MasterDash')

@section('content')
<div class="container-fluid px-4">
    <div class="row g-3 my-2 w-75 m-auto text-center bg-light text-dark p-5 rounded">
        <h3>Ajouter les détails</h3>

<form>
    <div class="mb-3">
        <label for="cat" class="form-label">Categories</label>
        <select class="form-control" name="categories" id="cat">
          <option>test 1</option>
          <option>test 2</option>
          <option>test 3</option>
        </select>
      </div>


    <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input placeholder="Titre" type="text" name="titre" class="form-control" id="titre">

      </div>
      <div class="mb-3">
        <label for="auteur" class="form-label">Auteurs</label>
        <select class="form-control" name="auteur" id="auteur">
          <option>test 1</option>
          <option>test 2</option>
          <option>test 3</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Prix</label>
        <input placeholder="Prix" type="text" name="prix" class="form-control" id="">

      </div>
      <div class="mb-3">
        <label for="isbn" class="form-label">ISBN</label>
        <input placeholder="ISBN" type="text" name="isbn" class="form-control" id="isbn">

      </div>
      <div class="mb-3">
        <label for="nb" class="form-label">Nombre de Pages</label>
        <input placeholder="Nombre de Pages" type="text" name="nbpages" class="form-control" id="nb">

      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Ajouter une Image</label>
        <input type="file" name="imagefile" class="form-control" id="image">

      </div>

    <button type="submit" class="btn btn-dark px-5">Ajouter</button>
  </form>
    </div>
</div>

@endsection
