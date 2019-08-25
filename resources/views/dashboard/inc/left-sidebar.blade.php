<!-- Sidebar Holder -->
{{-- @php $userpermission = new \App\Helpers\Upermissionhelper(); @endphp --}}
<nav id="sidebar" class="active hide-sidebar hide-total">
    <div class="sidebar-header">
        <h3>{{ env('APP_NAME', $default = 'DIGIPLAN') }}</h3>
        <strong>{{ substr(env('APP_NAME', $default = 'DIGIPLAN'), 0,4) }}</strong>
    </div>
    <div class="my-profile">
        <div class="my-profile-pic"><img alt="Employee image" class="img-circle client-img" src="http://192.168.0.104:1234/storage/image/employee/2d68184017f487f45264043a9ca59d1a.jpeg" width="60"></div>
        <div class="my-profile-name">
            <p>Arifur Chowdhury</p>
        </div>
    </div>
    <ul class="list-unstyled components">
        <li class="menu-section active">
            <a href="{{ url('dashboard') }}">
                <i class="fa fa-dashboard"></i>
                Skrivbord
            </a>
        </li>
        <li class="menu-section">
            <a href="#schedule_management" data-toggle="collapse" data-parent="#accordion" aria-expanded="false">
                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                Schema
            </a>
            <ul class="collapse list-unstyled" id="schedule_management">
                <li>
                    <a href="http://192.168.0.104:1234/schema">Schemahantering</a> <i class="fa fa-info-circle manual_btn" style="cursor: pointer;z-index: 9" data-manual-name="Grundschema" aria-hidden="true"></i>
                </li>
                <li>
                    <a href="http://192.168.0.104:1234/working_time_management_post">Helg, Röddag &amp; Ob</a><i class="fa fa-info-circle" aria-hidden="true"></i>
                </li>
                <li>
                    <a href="http://192.168.0.104:1234/working_time_management">Ob info</a><i class="fa fa-info-circle" aria-hidden="true"></i>
                </li>     
            </ul>
        </li>
    </ul>

</nav>

<div class="modal fade manual_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="manualEmbed"></div>
        </div>
      </div>
    </div>
</div>
