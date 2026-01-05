<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokemon Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="logo text-center">
            <img src="{{asset('IMG/logo.png') }}" alt="logo1">
        </div>
        <form action="{{ route('pokemon.index') }}" method="GET" id="filterForm">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter: {{ request('filter', 'ALL') }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('pokemon.index', ['filter' => 'all']) }}">ALL (Semua)</a></li>
                    <li><a class="dropdown-item" href="{{ route('pokemon.index', ['filter' => 'light']) }}">Light (100 - 150)</a></li>
                    <li><a class="dropdown-item" href="{{ route('pokemon.index', ['filter' => 'medium']) }}">Medium (151 - 199)</a></li>
                    <li><a class="dropdown-item" href="{{ route('pokemon.index', ['filter' => 'heavy']) }}">Heavy (>= 200)</a></li>
                </ul>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Base Experiance</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Ability</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pokemons as $p)
                <tr>
                    <td>{{$p->name}}</td>
                    <td>{{$p->base_experience}}</td>
                    <td>{{$p->weight}}</td>
                    <td>
                        @foreach($p->abilities as $ability)
                        {{ $ability->name }}
                        @endforeach
                    </td>
                    <td><img src="{{ $p->image_path }} " width="100" alt="{{ $p->name }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-5 mb-5 d-flex justify-content-center">
            {{ $pokemons->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>