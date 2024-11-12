
@foreach($registrations as $registration)
<p>{{ $registration->name }} - {{ $registration->nim }} - {{ $registration->status }}</p>
@if($registration->status == 'pending')
    <form action="{{ route('admin.approve', $registration->id) }}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit">Approve</button>
    </form>
@endif
@endforeach
