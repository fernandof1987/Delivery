@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span>
                            @if($xml->DocumentProperties->Module != '')
                                <b>{{ $xml->DocumentProperties->Module }}</b> -
                            @else
                                Módulo sem nome!!!!
                            @endif
                        </span>
                        <span class="">Alteração: {{ $xml->DocumentProperties->DataAtualizacao }}</span>
                    </div>

                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Status</th>
                                <th>Sub-Menu</th>
                                <th>Status</th>
                                <th>Sub-Menu Item</th>
                                <th>Status</th>
                                <th>Pes</th>
                                <th>Vis</th>
                                <th>Inc</th>
                                <th>Alt</th>
                                <th>Exc</th>
                                <th>Programa</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 1 ?>
                            @foreach($xml->Menu as $menu)
                                @foreach($menu->Menu as $subMenu)
                                    @foreach($subMenu->MenuItem as $menuItem)
                                        <tr>
                                            <td>{{ $count++ . " - " . $menu->Title }}</td>
                                            <td>
                                                @if($menu->attributes() == 'Enable')
                                                    <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:forestgreen"></span>
                                                @else
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red"></span>
                                                @endif
                                            </td>
                                            <td>{{ $subMenu->Title  }}</td>
                                            <td>
                                                @if($subMenu->attributes() == 'Enable')
                                                    <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:forestgreen"></span>
                                                @else
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red"></span>
                                                @endif
                                            </td>
                                            <td>{{ $menuItem->Title }}</td>
                                            <td>
                                                @if($menuItem->attributes() == 'Enable')
                                                    <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:forestgreen"></span>
                                                @else
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red"></span>
                                                @endif
                                            </td>
                                            <?php $a = str_split( $menuItem->Access ); ?>
                                            <th>{{ $a[0] }}</th>
                                            <th>{{ $a[1] }}</th>
                                            <th>{{ $a[2] }}</th>
                                            <th>{{ $a[3] }}</th>
                                            <th>{{ $a[4] }}</th>
                                            <td>{{ $menuItem->Function }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection