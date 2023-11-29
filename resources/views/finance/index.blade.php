@extends('layouts.app')
@section('content')
    <form action="{{ route('member.index') }}">
        @include('partials._search')
    </form>
    <x-card>
       

        <div class="card">
            <div class="card-header">{{ __('Finances') }}</div>
            <div class="card-body text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('No.') }}</th>
                            <th>{{ __('Member Name') }}</th>
                            <th>{{ __('Film') }}</th>
                            <th>{{ __('Code') }}</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataFin as $finance)
                            <tr>
                                <th>{{ ($dataFin->currentPage() - 1) * $dataFin->perPage() + $loop->iteration }}</th>
                                <td><a
                                        href="{{ route('member.show', ['member' => $finance->member_id]) }}">{{ $finance->member->NameCodeMemeber }}</a>
                                </td>
                                <td>
                                    @if ($finance->record->id == $finance->record_id)
                                        <strong>{{ __(' Name') }}:</strong>
                                        <a
                                            href="{{ route('film.show', ['film' => $finance->record->copy->film->id]) }}">{{ $finance->record->copy->film->name }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($finance->record->id == $finance->record_id)
                                        <strong>{{ __('Code') }}:</strong>
                                        <a
                                            href="{{ route('copy.show', ['copy' => $finance->record->copy->id]) }}">{{ $finance->record->copy->code }}</a>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="post" action="{{ route('finance.destroy', $finance) }}">
                                            @method('delete')
                                            @csrf
                                            <a href="{{ route('finance.show', $finance) }}" type="button"
                                                class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                                {{ __('Show') }}</a>
                                            <button type="submit" class="btn btn-danger btn-sm delete-button"><i
                                                    class="fa-solid fa-trash"></i> {{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $dataFin->links() }}
            </div>
        </div>
    </x-card>
@endsection
