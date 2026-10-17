@extends('layouts.app')

@section('title', 'Task Manager')

@section('content')
    <section class="hero">
        <p class="eyebrow">A little less waiting. A lot more doing.</p>
        <h1>Turn plans<br><span>into progress.</span></h1>
        <p class="lede">Make space for your next idea. Add the things you want to get done, keep them in view, and take them one step at a time.</p>
    </section>

    <section class="workspace" aria-label="Task workspace">
        <div class="panel">
            <div class="panel-heading">
                <div>
                    <h2>Add a task</h2>
                    <p>Start with one thing you want to move forward.</p>
                </div>
            </div>

            <div class="panel-body">
                @include('common.errors')

                <form action="{{ url('task') }}" method="POST">
                    {{ csrf_field() }}

                    <label class="field-label" for="task-name">What needs doing?</label>
                    <input
                        type="text"
                        name="name"
                        id="task-name"
                        class="task-input"
                        placeholder="Write a task..."
                        value="{{ old('name') }}"
                        maxlength="255"
                        required
                    >

                    <button type="submit" class="button add-button">
                        <span aria-hidden="true">+</span>
                        Add task
                    </button>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <div>
                    <h2>Your tasks</h2>
                    <p>Everything you have in motion, in one place.</p>
                </div>
                <span class="count" aria-label="{{ count($tasks) }} tasks">{{ count($tasks) }}</span>
            </div>

            @if (count($tasks) > 0)
                <ul class="task-list">
                    @foreach ($tasks as $task)
                        <li class="task-item">
                            <span class="task-name">{{ $task->name }}</span>

                            <form action="{{ url('/task/' . $task->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="delete-button" aria-label="Delete {{ $task->name }}">
                                    Delete
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="empty-state">Your list is clear for now. Add a task when you’re ready to get started.</p>
            @endif
        </div>
    </section>
@endsection
