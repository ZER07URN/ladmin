<x-ladmin-layout>
  <x-slot name="title">System Log</x-slot>
    
    <x-ladmin-card>
      <x-slot name="flat">
        <div class="table-responsive">
          <div class="top-button">
            <form action="">
              <select onchange="submit();" name="log" id="" class="form-control">
                @foreach ($files as $item)
                  <option {{ $file == $item ? 'selected' : null }} value="{{ $item }}">File {{ $item }}</option>
                @endforeach
              </select>
            </form>
          </div>
          <table class="table ladmin-datatables">
            <thead>
              <tr>
                <th width="20%">Date</th>
                <th width="10%">ENV</th>
                <th width="10%">Type</th>
                <th width="50%">Message</th>
                <th width="10%"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($logs as $i => $log)
                  <tr>
                    <td>
                      @if (isset($log['timestamp']))
                      <strong>{{ Carbon\Carbon::parse($log['timestamp'])->format('d/m/y H:i') }}</strong> <br/>
                      <small class="text-muted"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($log['timestamp'])->diffForHumans() }}</small>
                      @endif
                    </td>
                    <td>{{ $log['env'] ?? '-' }}</td>
                    <td>
                      <span class="badge badge-{{ $log['color'] ?? 'warning' }}">{{ $log['type'] ?? '-' }}</span>
                    </td>
                    <td>{{ Str::limit($log['message'], 50) ?? '-' }}</td>
                    <td class="text-center">
                      @include('ladmin::logs._partials._button_details', ['log' => $log, 'id' => $i])
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </x-slot>
    </x-ladmin-card>

</x-ladmin-layout>