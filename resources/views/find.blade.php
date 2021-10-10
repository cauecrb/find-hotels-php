<head>
    <title>Find Hotels</title>
    <meta charset="utf-8">
</head>

<h1>find hotels</h1>
<form action={{ route('find') }} method("post")>
    @csrf
    <div>
        Lat :
        <input type="text" name="lat">

        Long:
        <input  type="text" name="long">
    </div>
    <br>
    <div>
        Order by:
        <select name="orderby">
            <option value="0"> distance </option>
            <option value="1"> price </option>
        </select>
        Max distance: <input type="text" name="maxDist" value="30">
    </div>
    <button type="submit">find</button>
    <br>
    <br>
    @foreach ( $hotelsOrdered as $ordered )
       {{$ordered[0].', '.$ordered['KM']."KM".', '.$ordered[3]." EUR"}};
        <br>
    @endforeach
</form>
