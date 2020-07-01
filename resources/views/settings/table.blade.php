<table id="lista" class="table table-striped">
  <thead>
    <tr>
      <th>Opcion</th>
      <th>Valor</th>
    </tr>
  </thead>
  <tbody id="list-settings">
    @csrf
    @foreach( $settings as $setting )
    <tr>
      <td>{{ ucfirst( strtolower($setting->name) ) }}</td>
      <td>
        <input type="{{ $setting->field['type'] }}" id="{{ $setting->id }}" name="value" value="{{ $setting->value }}" class="{{ $setting->field['type'] }} form-control" required>
        <span id="{{ $setting->id }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>