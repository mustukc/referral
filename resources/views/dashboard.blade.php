@extends('layouts/dashboradLayout')



@section('content-section')
<h2 class="mb-4" style="float:left;">Dashborad</h2>
<h2 class="mb-4" style="float:right;">{{$networkCount*10}} points</h2>
<table class="table">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      
    </tr>
  </thead>
  <tbody>
    @if(count($networkData)>0)
    @php $x=0; @endphp
       @foreach($networkData as $network)
         <tr>
            <td>{{$x++}}</td>
            <td>{{$network->user->name}}</td>
            <td>{{$network->user->email}}</td>
         </tr>
       @endforeach
    @else
    <tr>
         <th colspan="4"> No Referrals Found</th>
        </tr>
    @endif
 </tbody>
</table>

 


@endsection