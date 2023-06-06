@extends('admin.layout.app')

@section('heading', 'Edit Photo Page')


@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin_page_photo_update') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                               
                                <div class="mb-4">
                                    <label class="form-label">Photo Heading *</label>
                                    <input type="text" class="form-control" name="photo_heading" value="{{ $page_data->photo_heading }}">
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Status</label>
                                    <select name="photo_status" id="" class="form-control">
                                        <option value="1" @if ($page_data->photo_status==1)
                                            
                                        @endif>Show</option>
                                        <option value="0" @if ($page_data->photo_status==0)
                                        @endif>Hide</option>                                
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label"></label>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection