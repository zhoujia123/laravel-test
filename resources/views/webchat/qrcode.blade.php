@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <img alt="模式二扫码支付" src="/wx/qrcode?data={{urlencode($code_url)}}" style="width:150px;height:150px;"/>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-11">
                <a href="{{ url('/wx/jschat?product_id=2') }}">JS支付</a>
            </div>
        </div>
    </div>
@endsection
