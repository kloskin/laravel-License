<x-app-layout>

    <h1>Licencje</h1>
    
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nazwa</th>
                <th>Kategoria</th>
                <th>Opis</th>
                @canany(['isModerator','isAdmin'])
                <th>Akcje</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
        @foreach($licenses as $license)
            <tr>
                <td>{{ $license->name }}</td>
                <td>{{ $license->category->name }}</td>
                <td>{{ $license->description }}</td>
                @canany(['isModerator','isAdmin'])
                <td>
                    <a href="{{ route('licenses.edit', $license) }}">Edytuj</a>
                    <form action="{{ route('licenses.destroy', $license) }}" method="POST" style="display:inline-block;">
                        @csrf 
                        @method('DELETE')
                        <button type="submit">Usuń</button>
                    </form>
                </td>
                @endcanany
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>
