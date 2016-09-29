@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Pedidos Para Conferir <a href="/logistica/conferencia"><span class="glyphicon glyphicon-refresh pull-right" aria-hidden="true"></span></a></div>
                    <div class="panel-body">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Linha</th>
                                    <th>Pedido</th>
                                    <th>Cliente Cod</th>
                                    <th>Cliente Nome</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                @foreach($pedidos as $pedido)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $pedido->PdV_Numero }}</td>

                                    <td>{{ $pedido->Cli_Cod }}</td>
                                    <td>{{ $pedido->Cli_Nome }}</td>
                                    <td>{{ $pedido->DataUltimaAlteracao }}</td>
                                    {{--
                                    <td>
                                        @if($pedido->statusId == 3)     Separado
                                        @elseif($pedido->statusId == 4) Conferir
                                        @elseif($pedido->statusId == 5) Conferindo
                                        @elseif($pedido->statusId == 6) Conferido
                                        @endif
                                    </td>
                                    --}}
                                </tr>
                                <?php $i++ ?>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>

        function atualizaPagina() {
            setInterval(function(){
                location.reload();
            }, 10000);
        }
        atualizaPagina();

    </script>

@endsection