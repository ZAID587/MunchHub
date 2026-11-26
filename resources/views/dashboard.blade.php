@if(Auth::user()->isAdmin())
    <script>window.location.href = "{{ route('admin.pedidos') }}";</script>
@else
    <script>window.location.href = "{{ route('client.inicio') }}";</script>
@endif