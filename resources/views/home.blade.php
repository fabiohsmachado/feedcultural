<!DOCTYPE html>
<html>

<head>
    <title>Feed Cultural</title>
</head>

<body>
    <h2>Escolha uma ou mais fontes:</h2>

    <form action="/" method="POST">
        @csrf

        <div id="source_list">
            @forelse($sources as $source)
                <input type="checkbox" name="{{ $source->getId() }}">
                <label for="{{ $source->getId() }} "> {{ $source->getName() }} </label>
                <br />
            @empty
                <p>Nenhuma fonte de dados.</p>
            @endforelse
        </div>

        <input type="submit" value="Enviar">
    </form>

    <div class="feed" id="feed_response">
        @if (isset($feed))
            Feed: {{ $feed->getUrl() }}.
            <br />
            Email: {{ $feed->getEmail() }}
        @endif
    </div>
</body>

</html>
