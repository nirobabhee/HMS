<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescription PDF</title>
    <style>
body{
    max-width: 95%;
    margin: auto;
}
.patient{
    display: inline-block;
    width: 50%;
}
.hospital{
    display: inline-block;
    width: 50%;
}

.left-element {
    display: inline-block;
    width: 30%;
}

.right-element{
    display: inline-block;
    width: 65%;
    /* margin-left: 30px; */
}


.prescription {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.prescription td, #prescription th {
  border: 1px solid #ddd;
  padding: 8px;
}

.prescription tr:nth-child(even){background-color: #f2f2f2;}

.prescription tr:hover {background-color: #ddd;}

.prescription th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #855edf;
  color: white;
}
    </style>
</head>
<body>

    <div class="patient">ipsum dolor sit amet consectetur adipisicing elit. Officiis animi voluptatibus eos quo maiores, recusandae harum corrupti ducimus officia in eligendi ad cumque odit reprehenderit, vel deserunt vitae deleniti iusto?111Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis animi voluptatibus eos quo maiores, recusandae harum corrupti ducimus officia in eligendi ad cumque odit reprehenderit, vel deserunt vitae deleniti iusto?</div>
    <div class="hospital">ipsum dolor sit amet consectetur adipisicing elit. Officiis animi voluptatibus eos quo maiores, recusandae harum corrupti ducimus officia in eligendi ad cumque odit reprehenderit, vel deserunt vitae deleniti iusto?111Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis animi voluptatibus eos quo maiores, recusandae harum corrupti ducimus officia in eligendi ad cumque odit reprehenderit, vel deserunt vitae deleniti iusto?</div>



<div class="left-element">
    111Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis animi voluptatibus eos quo maiores, recusandae harum corrupti ducimus officia in eligendi ad cumque odit reprehenderit, vel deserunt vitae deleniti iusto?111Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis animi voluptatibus eos quo maiores, recusandae harum corrupti ducimus officia in eligendi ad cumque odit reprehenderit, vel deserunt vitae deleniti iusto?
</div>


<div class="right-element">
    <table class="prescription">
        <thead>
          <tr>
            <th>@lang('S.N.')</th>
            <th>@lang('Medicine Name')</th>
            <th>@lang('Type')</th>
            <th>@lang('Days')</th>
            <th>@lang('Instruction')</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($prescription->medicine as $medicine)
            <tr>
              <td >{{ $loop->iteration}}</td>
              <td >{{ @$medicine->medicine_name}}</td>
              <td >{{ @$medicine->medicine_type}}</td>
              <td >{{@$medicine->days}}</td>
              <td >{{ @$medicine->medicine_instruction}}</td>
            </tr>
            @empty
              <tr> @lang('No medicine prescribed')</tr>
            @endforelse


        </tbody>
      </table>

      {{-- //diagnosis --}}
      <table class="prescription">
        <thead>
          <tr>
            <th>@lang('S.N.')</th>
            <th>@lang('Diagnosis')</th>
            <th>@lang('Instruction')</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($prescription->diagnosis as $diagnosis)
            <tr>
              <td >{{ $loop->iteration}}</td>
              <td >{{$diagnosis->diagnosis}}</td>
              <td >{{$diagnosis->diagnosis_instruction}}</td>
            </tr>

            @endforeach
        </tbody>
      </table>
</div>
</body>
</html>
