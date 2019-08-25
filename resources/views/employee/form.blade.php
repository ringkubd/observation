
    {{csrf_field()}}
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="name">
            Name
        </label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="name" name="name" value="{{$model->name}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="email">Email</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="email" name="email" value="{{$model->email}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="password">Password</label>
        <input type="password" class="form-control mr-sm-2 mb-2 mb-sm-0" id="password" name="password"  value="">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="branch_id">Branch</label>
        <select  class="form-control mr-sm-2 mb-2 mb-sm-0 select2" name="branch_id[]" id="branch_id"  multiple="multiple">
            <option value="0">Select a branch</option>
            {!! $branch !!}
        </select>
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="code">Code</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="code" name="code"  value="{{$model->code}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="code_converter">Code Converter</label>
        <input type="checkbox" class="form-control mr-sm-2 mb-2 mb-sm-0" id="code_converter" name="code_converter" @if($model->code_converter ==1) checked @endif  value="1">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="employee_access">Employee Access</label>
        <input type="checkbox" class="form-control mr-sm-2 mb-2 mb-sm-0" id="employee_access" name="employee_access" @if($model->employee_access ==1) checked @endif  value="1">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="branch_access">Branch Access</label>
        <input type="checkbox" class="form-control mr-sm-2 mb-2 mb-sm-0" id="branch_access" name="branch_access" @if($model->branch_access ==1) checked @endif  value="1">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="client_access">Client Access</label>
        <input type="checkbox" class="form-control mr-sm-2 mb-2 mb-sm-0" id="client_access" name="client_access" @if($model->client_access ==1) checked @endif  value="1">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="observer_man_access">Observer Management Access</label>
        <input type="checkbox" class="form-control mr-sm-2 mb-2 mb-sm-0" id="observer_man_access" name="observer_man_access" @if($model->observer_man_access) checked @endif  value="1">
    </div>

