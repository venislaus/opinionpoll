@extends('layout')

@section('content')
<style>
    .uper {
        margin-top: 40px;
        text-align: center;
    }
    #container { text-align: center; margin: 20px; }
    h2 { color: #CCC; }
    a { text-decoration: none; color: #EC5C93; }
    .bar-main-container {
        margin: 10px auto;
        width: 300px;
        height: 55px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        font-family: sans-serif;
        font-weight: normal;
        font-size: 0.8em;
        color: #FFF;
    }
    .wrap { padding: 8px; }
    .bar-percentage {
        float: left;
        background: rgba(0,0,0,0.13);
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        padding: 7px 15px;
        width: 18%;
        height: 30px;
        margin-top: -18px;
    }

    .bar-container {
        float: right;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        height: 10px;
        background: rgba(0,0,0,0.13);
        width: 78%;
        margin: 0px 0px;
        overflow: hidden;
    }
    .bar-main-container .txt{
        padding-top: 5px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    .bar {
        float: left;
        background: #FFF;
        height: 100%;
        -webkit-border-radius: 10px 0px 0px 10px;
        -moz-border-radius: 10px 0px 0px 10px;
        border-radius: 10px 0px 0px 10px;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
        filter: alpha(opacity=100);
        -moz-opacity: 1;
        -khtml-opacity: 1;
        opacity: 1;
    }

        /* COLORS */
    .azure   { background: #38B1CC; }
    .emerald { background: #2CB299; }
    .violet  { background: #8E5D9F; }
    .yellow  { background: #EFC32F; }
</style>
<div class="uper">
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div><br />
    @endif
    <h3>Results</h3>
    <p><b>Total Votes:</b> <?php echo count($polls); ?></p>
    <?php

        if(count($polls) > 0){ $i=0;
        //Option bar color class array
        $barColorArr = array('azure','emerald','violet','yellow');
        //Generate option bars with votes count
        foreach($opinions as $o){
        //Calculate vote percent
        $votePercent = round(($o->PollCount/count($polls))*100);
        $votePercent = !empty($votePercent)?$votePercent.'%':'0%';
        //Define bar color class
        if(!array_key_exists($i, $barColorArr)){
        $i=0;
        }
        $barColor = $barColorArr[$i];
    ?>
    <div class="bar-main-container <?php echo $barColor; ?>">
        <div class="txt"><?php echo $o->name; ?></div>
        <div class="wrap">
            <div class="bar-percentage"><?php echo $votePercent; ?></div>
            <div class="bar-container">
                <div class="bar" style="width: <?php echo $votePercent; ?>;"></div>
            </div>
        </div>
    </div>
<?php $i++; } } ?>
    <div>
        <a href="{{ route('poll.create')}}" class="btn btn-primary">Back</a>
        @endsection