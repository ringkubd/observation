
    {{csrf_field()}}
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="branch_name">
            Client Name
        </label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="client_name" name="client_name" value="{{$model->client_name}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="branch_id">Branch</label>
        <select class="form-control mr-sm-2 mb-2 mb-sm-0" name="branch_id" id="branch_id">
            <option value="">Select a branch</option>
            {!! $branchOption !!}
        </select>
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="code">Code</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="code" name="code"  value="{{$model->code}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="code_converter">Code Converter</label>
        <input type="checkbox" class="form-control" id="code_converter" name="code_converter" @if($model->code_converter) checked @endif  value="1">
    </div>


