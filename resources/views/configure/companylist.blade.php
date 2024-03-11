@extends('layouts.master')
@section('title') COMPANY LIST @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">COMPANY LIST</h5>
            </div>
            <div class="card-body changePageAction">
                @if(session('success_msg')) 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b>{{session('success_msg')}}.</b> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif(session('error_msg')) 
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <b>{{session('error_msg')}}.</b> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif  

                <div class="row"> 
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <a class="float-right btn btn-xs btn-primary float-right btn-flat"
                        href="{{ route('company.export') }}">
                        <i class="ri-export-fill"></i> Export</a> 
                        <a href="{{url('/')}}/company_card" class="btn btn-primary" style="float: right;"><i class="ri-add-box-line"></i> New</a>
                    </div>
                </div> <br> 

                
                <table id="CompanyTable" class="display table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Creation</th>
                            <th>Registered by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($listCompany))
                        @foreach($listCompany as $companyData)
                        <tr>
                            <td>{{$companyData->company_id}}</td>
                            <td>{{$companyData->name}}</td>
                            <td><div class="col-md-6 position-relative form-check form-switch form-switch-lg" style="margin-left: 50px;"><input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" {{($companyData->status==1 ? "checked" : "")}}></div></td>
                            <td>{{$companyData->created_at}}</td> 
                            <td>{{$companyData->register_by}}</td> 
                            <td><a href="{{url('/').'/company_card_edit/'}}{{$companyData->company_id}}" class="btn btn-primary"><i class="ri-edit-2-line"></i> Edit</a>
                                <!-- <a href="{{url('/').'/company_card_delete/'}}{{$companyData->company_id}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete ?')"><i class="ri-delete-bin-line"></i> Delete</a> -->
                            </td> 
                            </tr>
                            @endforeach 
                            @endif
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script type="text/javascript">
        var table = $('#CompanyTable').DataTable({
            processing: true, 
            responsive: true,
            pageLength: 25,
            columnDefs: [
            {"className": "dt-center", "targets": "_all"}
            ],
        });
        
    </script>
    @endsection