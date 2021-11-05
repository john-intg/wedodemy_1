@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Student Answers</div>

                <div class="card-body">
                    @if(count($courses)>0)
                        @foreach($courses as $course)
                            {{$course->title}}<br>
                            @foreach($course->answers as $answer)
                            <?php $studentNames = array_unique($answer->user->pluck('name')->all()); ?>
                                @foreach($studentNames as $studentName)
                                    {{$studentName}}
                                @endforeach
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
