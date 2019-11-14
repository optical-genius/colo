<table border="1px solid">
    <?php
    $i = 0;

    ?>
    {{'Память: '. $memorylim .' мб.'}}<br>
    {{'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.'}}
@foreach($records as $record)
<?php

$i++;
?>
<tr>
    <td><b>{{$i}}</b></td>
    <td>{{$record->values('ip_name')[0]}}</td>
    <td>
        @foreach($record->values('ip_name')[1] as $host)
        {{$host}}<br>
        @endforeach
    </td>

{{--    {{$i}} - {{print_r($record->values('ip_name')[0])}} - {{print_r($record->values('ip_name')[1])}}--}}
</tr>

@endforeach
</table>
