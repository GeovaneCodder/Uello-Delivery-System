@extends('index')
@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <td scope="col">Nome</td>
            <td scope="col">Email</td>
            <td scope="col">Data de Nasc.</td>
            <td scope="col">CPF</td>
            <td scope="col">Endereço</td>
            <td scope="col">CEP</td>
            <th scope="col" style="text-align: center;">Rota</th>
        </tr>
    </thead>
    <tbody>
    @forelse($clients as $client)
        <tr>
            <td>{{$client->name}}</td>
            <td>{{$client->email}}</td>
            <td>{{$client->birthday}}</td>
            <td>{{$client->document_number}}</td>
            <td>{{$client->address->address}}, {{$client->address->number}} {{$client->address->complement}}, {{$client->address->neighborhood}} - {{$client->address->city}}</td>
            <td>{{$client->address->zip_code}}</td>
            <th style="text-align: center;">
                <button data-toggle="modal" data-target=".bd-example-modal-lg" onclick="openModal({{$client->address->latitude}}, {{$client->address->longitude}});">
                    <img src="https://cdn6.aptoide.com/imgs/0/b/a/0ba895e28bd660280ab3ac116d88e7b0_icon.png?w=25" />
                </button>
            </th>
        </tr>      
        @empty
        <h4 style="text-align: center; color: #fff;">Sem dados</h4>
    @endforelse
    </tbody>
</table>
<div class="col-md-12">
    <a class="a-export"><button class="btn-home export-csv">Exportar CSV</button></a>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="col-md-6" style="float: left;">
                <div id="mapa" style="width:100%; height: 350px"></div>
            </div>

            <div class="col-md-6" style="float: right;">
                <div id="directionsPanel" style="width:100%; height: 350px; overflow: scroll; "></div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection