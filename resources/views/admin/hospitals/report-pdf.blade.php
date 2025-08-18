<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Hospitals Report</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
    table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    th, td {
      border: 1px solid #ddd;
      padding: 4px;
      word-wrap: break-word;
      white-space: normal;
    }
    th { background: #f5f5f5; }
  
    /* Custom column widths */
    th.org, td.org { width: 20%; }
    th.contact, td.contact { width: 20%; }
    th.address, td.address { width: 20%; }
  </style>  
</head>
<body>
  <h3>Hospitals Report</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th class="org">Organization</th>
        <th class="contact">Contact Info</th>
        <th class="address">Address</th>
        <th>Valentine Cards</th>
        <th>Staff Cards</th>
        <th>Box</th>
        {{-- <th>Dim</th> --}}
        <th>Empty</th>
        <th>Weight</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
        <tr>
          <td>{{ $r->id }}</td>
          <td class="org">{{ $r->organization_name }}</td>
          <td class="contact">
            {{ $r->contact_person_name }}<br>{{ $r->email }}<br>{{ $r->phone }}
          </td>
          <td class="address">
            {{ $r->street }}, {{ $r->city }}, {{ $r->state }} {{ $r->zip }}
          </td>
          <td>{{ $r->valentine_card_count }}</td>
          <td>{{ $r->extra_staff_cards }}</td>
          <td>{{ $r->box_style }}<br>{{ $r->length }}x{{ $r->width }}x{{ $r->height }}</td>
          <td>{{ $r->empty_box }}</td>
          <td>{{ $r->weight }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
