<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
  border-top: 0;
}
.table tr th {
  text-align: center;
  font-size: 15px;
}
.text-white {
  color: #fff;
}
.bg-white {
  background: #fff;
  margin: 5px;
  padding: 10px;
}
.bg-white h1{
  margin: 0;
}
</style>

<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step1')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}" @if($clients->id==$request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 1</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div id="dynamic_content">
      @include('operant._verktyg_step1')
    </div>

  </div>
</section>

