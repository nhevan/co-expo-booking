@extends('layouts.generic')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Exposition Hall Map
                    <a href="/" class="btn-sm btn-primary pull-right">
                        Back to Event Map
                    </a>
                </div>

                <div class="panel-body">
                    <div id="exposition-hall-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection