@extends('layouts.app-client', ['title' => __($setup['title'])])
@section('js')
    @yield('js')
@endsection
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
<style>
    .fetch-btn{
        position: relative;
        top: -29px;
        left: 85%;
    }

    .table .thead-dark th {
        color: #000000;
        background-color: #ffffff;
    }
    .disconnect{
        border: 1px solid red;
        padding: 5px;
        color: red;
        border-radius: 6px;
    }
    .active_status{
        border: 1px solid #3b3eaf;
        padding: 5px;
        color: #3451a3;
        border-radius: 6px;
    }
</style>

<div class="header pb-8 pt-2 pt-md-7">
    <div class="container-fluid">
        <div class="header-body">
            <h1 class="mb-3 mt--3">{{$setup['title']}}</h1>
            <div class="row align-items-center pt-2">
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--8">  
    <div class="row">
        <div class="col-12 my-4">
            <a href="{{Route('Catalog.fetchCatalog')}}" class="btn btn-primary fetch-btn">
            <i class="fa-solid fa-rotate" ></i><span>Sync</span></a>
            <div class="card shadow max-height-vh-70 overflow-auto overflow-x-hidden">
                <div class="card-body overflow-auto overflow-x-hidden scrollable-div" ref="scrollableDiv">
                @if(Session::has('message'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                        {{ Session::get('message') }}
                        </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12 show-product">
                        <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                       <th>{{ __('Name') }}</th>
                                       <th>{{ __('Catalogue Id') }}</th>
                                       <!-- <th>{{ __('Type') }}</th> -->
                                       <th>{{ __('Product Count') }}</th>
                                       <th>{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($catalogs as $catalog)
                                       @php
                                          $products_count = App\Models\CatalogProduct::where('catalog_id',$catalog->catalog_id)->where('company_id',$catalog->company_id)->get();
                                         
                                       @endphp
                                        <tr>
                                            <td>{{ $catalog->name }}</td>
                                            <td>{{ $catalog->catalog_id }}</td>
                                            <!-- <td>{{ $catalog->name }}</td> -->
                                            <td>{{ count($products_count ?? 0) }}</td>
                                            <td>
                                            @if($catalog->status)
                                                <a class="disconnect" href="">
                                                    Disabled
                                                </a>
                                            @else
                                                <a class="active_status" href="">
                                                    Enabled
                                                </a>
                                            @endif
                                        </td>
                                        </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
        </div>  
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" ></script>
<script>
    $(document).ready(function() {
        $('.select-catalog').change(function() {
            var url = "{{Route('Catalog.index')}}";
            catalog_id = $(this).val();
            updateURL(catalog_id);
            $.ajax({
                url: url,
                method: "get",
                data: { 'catalog_id': catalog_id },
                success: function(result) {
                    console.log(result);
                    $('.show-product').html(result);
                }
            });
        });
    });
    function updateURL(catalog_id=null,) {
        var url = new URL(window.location.href);
        url.searchParams.set('catalog_id', catalog_id);
        history.pushState(null, '', url.toString());
    }
</script>
@endsection