@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">XNU</div>

                    <div class="panel-body">
                        <form action="/xnu/upload" method="post" class="well form-inline" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                Escolher Arquivo: <input name="file" type="file" class="btn btn-default form-control"/>
                                <input type="submit" value="ok" class="btn btn-default">
                            </div>
                        </form>

                        @foreach($files as $file)
                            <?php $_file = explode("/", $file) ?>
                            <a href="/xnu/lista/<?php echo end($_file) ?> " class="btn btn-primary">{{ end($_file) }}</a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection