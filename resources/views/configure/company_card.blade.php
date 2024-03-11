@extends('layouts.master')
@section('title') Company Card @endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center">COMPANY CARD</h4> 
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <form class="row g-3 needs-validation" method="post" action="{{url('company_card')}}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="ID" class="form-label">ID</label>
                            <input type="text" class="form-control" id="ID" value="{{$newInsertID}}" required="" disabled=""> 
                        </div>
                        <div class="col-md-3 position-relative"></div>



                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="name" class="form-label">Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required=""> 
                            <span style="color: red;">@if($errors->has('name'))
                                {{ $errors->first('name')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="rut" class="form-label">RUT <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="rut" id="rut" value="{{ old('rut') }}" required placeholder="11.111.111-1"> 
                            <span style="color: red;">@if($errors->has('rut'))
                                {{ $errors->first('rut')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="business" class="form-label">Business </label>
                            <input type="text" class="form-control" name="business_activity" value="{{ old('business_activity') }}" id="business" > 
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="logo" class="form-label">Logo <span style="color: red">*</span></label>
                            <input type="file" class="form-control" name="logo" id="logo" required> 
                            <span style="color: red;">@if($errors->has('logo'))
                                {{ $errors->first('logo')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="webpage_url" class="form-label">Webpage </label>
                            <input type="text" class="form-control" name="webpage_url" value="{{ old('webpage_url') }}" id="webpage_url"> 
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-3 position-relative">
                            <label for="rrss_url" class="form-label">Main Url RRSS </label>
                            <input type="text" class="form-control" name="rrss_url" id="rrss_url" value="{{ old('rrss_url') }}" > 
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="rrss" class="form-label">&nbsp; </label>
                            <select class="form-control form-select" id="rrss" name="rrss_type_id"  >
                                <option value="">Select RRSS Type</option>
                                @if(isset($listRsstype))
                                @foreach( $listRsstype as $rrsstype )
                                <option value="{{ $rrsstype->rrss_type_id }}" {{ old('rrss_type_id') == $rrsstype->rrss_type_id ? 'selected' : '' }} >{{ $rrsstype->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="address_line_1" class="form-label">Address Line 1 <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="address_line_1" id="address_line_2" value="{{ old('address_line_1') }}" required> 
                            <span style="color: red;">@if($errors->has('address_line_1'))
                                {{ $errors->first('address_line_1')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative">
                            <label for="address_line_2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" name="address_line_2" value="{{ old('address_line_2') }}" id="address_line_2"> 
                        </div>
                        <div class="col-md-3 position-relative"></div>


                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-3 position-relative">
                            <label for="region_id" class="form-label">Region </label>
                            <select class="form-control form-select" id="region_id" name="region_id">
                                <option value="">Select Region</option>
                                @if(isset($listRegion))
                                @foreach( $listRegion as $value )
                                <option value="{{ $value->region_id }}" {{ old('region_id') == $value->region_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span style="color: red;">@if($errors->has('region_id'))
                                {{ $errors->first('region_id')}} 
                                @endif
                            </span>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="comuna_id" class="form-label">Comuna</label>
                            <select class="form-control form-select" id="comuna_id" name="comuna_id" >
                                <option value="">Select Comuna</option> 
                            </select>
                            <span style="color: red;">@if($errors->has('comuna_id'))
                                {{ $errors->first('comuna_id')}} 
                                @endif
                            </span>
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-6 position-relative form-check form-switch form-switch-lg">
                            <label class="form-check-label" for="customSwitchsizelg">Status</label>
                            <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="status" checked="">
                        </div> 
                        <div class="col-md-3 position-relative"></div>

                        <div class="col-md-3 position-relative"></div>
                        <div class="col-md-5">
                            <a href="javascript:window.history.back()" class="btn btn-danger" ><i class="ri-close-line"></i> Cancel</a>
                        </div>
                        <div class="col-md-3 position-relative">
                            <button class="btn btn-primary" type="submit"><i class="ri-save-line"></i> Save</button>
                        </div> 
                    </form>
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
@endsection


