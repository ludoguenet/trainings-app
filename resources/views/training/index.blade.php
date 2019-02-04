@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Les formations</h1>
                @foreach($trainings as $training)
                <div class="card mb-5">
                <div class="card-header">{{ $training->name }}</div>
                <img class="card-img-top" src="{{ asset($training->image) }}" alt="Card image cap">
                <div class="card-body">
                    <p><small class="text-secondary">Auteur : {{ $training->author }}</small></p>
                    <h5 class="card-title">Cette formation démarre le <span class="text-success">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $training->starts_at)->format('d/m/Y à H:i') }}</span></h5>
                    <p class="card-text">{{ str_limit($training->description, 200, '...') }}</p>
                    <p>Les personnes inscrites à cette formation : @forelse($training->users->sortByDesc('created_at') as $user) <b>{{ $user->name }}@if(!$loop->last), @else. @endif</b> @empty <small class="text-info">Aucun participant pour l'instant.</small>@endforelse</p>
                    @guest
                    <p><small class="text-dark"><a href="{{ route('login') }}">Connectez-vous</a> pour  participer à cette formation !</small></p>
                    @else
                        @if(Auth::user()->name != $training->author)
                        <form action="{{ route('training.addUser', ['training_id' => $training->id, 'user_id' => Auth::user()->id]) }}" method="POST">
                        @csrf
                        <input type="submit" value="Participer à cette formation" class="btn btn-primary">
                        </form>
                        @endif
                    @endguest
                </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection