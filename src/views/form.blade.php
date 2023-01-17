<form method='POST' action='{{ $requestUrl }}'>
    @foreach ($avvio->toArray() as $name => $value)
        @if($name == "dati_aggiuntivi_json")
            @continue
        @elseif($name == "facoltativi_json")
        @foreach ($value as $subkey => $subvalue)
        <label>{{$name}} - {{$subkey}}</label>
            <input  name='{{ $subkey }}' value='{{ $subvalue }}' />
        @endforeach
        @else
        <label>{{$name}}</label>
        <input  name='{{ $name }}' value='{{ $value }}' />
         @endif
    @endforeach
    
    @if(!isset($slot) || strlen($slot) == 0)
    <input type='submit' value='VAI ALLA PAGINA DI CASSA' />
    @else
    {{$slot}}
    @endif
</form>