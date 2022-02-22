@extends('Master.MasterHome')
@section('title')
    Finalisation de la commande
@endsection

@section('content')
    <div class="container">
        <main>
            <div class="py-5 text-center">
              <img class="d-block mx-auto mb-4" src="{{ asset('images/delivery.gif') }}" alt="" width="72" height="57">
              <h2>Finalisation de la commande</h2>
              <p class="lead">Veuillez remplir tous les champs correctement, s'il vous plait, et tapez sur 'Envoyer'</p>
            </div>

            <div class="row g-5">
              <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                  <span class="text-warning">Votre Panier</span>
                  <span class="badge bg-warning rounded-pill">{{ Cart::content()->count() }}</span>
                </h4>
                @php
                $total = 0;
            @endphp
                <ul class="list-group mb-3">
                    @foreach ( Cart::content() as $array)
                    @php
                    $total += $array->price*$array->qty;
                @endphp
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0">{{ $array->name }}</h6>
                      <small class="text-muted">Quantity : {{ $array->qty }}</small>
                    </div>
                    <span class="text-muted">{{ $array->price }}</span>
                  </li>
                  @endforeach
                  <!--li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-success">
                      <h6 class="my-0">Promo code</h6>
                      <small>EXAMPLECODE</small>
                    </div>
                    <span class="text-success">−$5</span>
                  </li-->
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Total (DH)</span>
                    <strong>{{ $total }}</strong>
                  </li>
                </ul>

                <!--form class="card p-2">

                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                    <button type="submit" class="btn btn-secondary">Redeem</button>
                  </div>
                </form-->
              </div>
              <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Adresse de livraison</h4>
                <form class="needs-validation" action="{{ route('cmd.envoyer') }}" method="post">
                    @csrf
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label for="firstName" class="form-label">Prenom *</label>
                      <input type="text" class="form-control" name="shipprenom" id="firstName" placeholder="" value="" required>
                      <div class="invalid-feedback">
                        Valid first name is required.
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <label for="lastName" class="form-label">Nom *</label>
                      <input type="text" class="form-control" name="shipnom" id="lastName" placeholder="" value="" required>
                      <div class="invalid-feedback">
                        Valid last name is required.
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="phone" class="form-label">Numéro de téléphone mobile *</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text">+212</span>
                        <input type="text" class="form-control" name="phone" id="phone" required>
                      <div class="invalid-feedback">
                          Your username is required.
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <label for="address" class="form-label">Address *</label>
                      <input type="text" class="form-control" name="adresse" id="address" placeholder="Rue / Appartement / Suite / Bloc / Bâtiment" required>
                      <div class="invalid-feedback">
                        Please enter your shipping address.
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="address2" class="form-label">Infos complémentaires<span class="text-muted">(Optional)</span></label>
                      <input type="text" class="form-control" id="address2" name="infosup" placeholder="Détails supplémentaires sur l'adresse">
                    </div>


                    <div class="col-md-4">
                      <label for="state" class="form-label">Region *</label>
                      <select name="region" class="form-select" id="state" required>
                        <option value="Chaouia-Ouardigha">Chaouia-Ouardigha</option>
                        <option value="Doukkala-Abda">Doukkala-Abda</option>
                        <option value="Fès-Boulemane">Fès-Boulemane</option>
                        <option value="Gharb-Chrarda-Béni Hssen">Gharb-Chrarda-Béni-Hssen</option>
                        <option value="Grand Casablanca" selected="selected">Grand-Casablanca</option>
                        <option value="Guelmim-Es Smara">Guelmim-Es-Smara</option>
                        <option value="Laâyoune-Boujdour-Sakia el Hamra">Laâyoune-Boujdour-Sakia-el-Hamra</option>
                        <option value="Marrakech-Tensift-Al Haouz">Marrakech-Tensift-Al-Haouz</option>
                        <option value="Meknès-Tafilalet">Meknès-Tafilalet</option>
                        <option value="Oriental">Oriental</option>
                        <option value="Oued Ed-Dahab-Lagouira">Oued Ed-Dahab-Lagouira</option>
                        <option value="Rabat-Salé-Zemmour-Zaër">Rabat-Salé-Zemmour-Zaër</option>
                        <option value="Souss Massa-Draâ">Souss-Massa-Draâ</option>
                        <option value="Tadla-Azilal">Tadla-Azilal</option>
                        <option value="Tanger-Tétouan">Tanger-Tétouan</option>
                        <option value="Taza-Al Hoceïma-Taounate">Taza-Al-Hoceïma-Taounate</option>
                      </select>
                      <div class="invalid-feedback">
                        Please provide a valid state.
                      </div>
                    </div>
                    <div class="col-md-4">
                        <label for="state" class="form-label">Ville *</label>
                        <select name="ville" class="form-select" id="state" required>
                            <option value="Casablanca" selected> Casablanca</option>
                            <option value="Agadir"> Agadir</option>
                            <option value="Al Hoceima"> Al Hoceima</option>
                            <option value="Béni Mellal"> Béni Mellal</option>
                            <option value="El Jadida"> El Jadida</option>
                            <option value="Errachidia"> Errachidia</option>
                            <option value="Fès"> Fès</option>
                            <option value="Kénitra"> Kénitra</option>
                            <option value="Khénifra"> Khénifra</option>
                            <option value="Khouribga"> Khouribga</option>
                            <option value="Larache"> Larache</option>
                            <option value="Marrakech"> Marrakech</option>
                            <option value="Meknès"> Meknès</option>
                            <option value="Nador"> Nador</option>
                            <option value="Ouarzazate"> Ouarzazate</option>
                            <option value="Oujda"> Oujda</option>
                            <option value="Rabat"> Rabat</option>
                            <option value="Safi"> Safi</option>
                            <option value="Settat"> Settat</option>
                            <option value="Salé"> Salé</option>
                            <option value="Tanger"> Tanger</option>
                            <option value="Taza"> Taza</option>
                            <option value="Tétouan"> Tétouan</option>
                        </select>
                        <div class="invalid-feedback">
                          Please provide a valid state.
                        </div>
                      </div>

                    <div class="col-md-3">
                      <label for="zip" class="form-label">Zip</label>
                      <input name="zip" type="text" class="form-control" id="zip" placeholder="" required>
                      <div class="invalid-feedback">
                        Zip code required.
                      </div>
                    </div>
                  </div>

                  <hr class="my-4">




                  <input class="w-100 btn btn-primary btn-lg" type="submit">
                </form>
              </div>
            </div>
          </main>
    </div>
@endsection
