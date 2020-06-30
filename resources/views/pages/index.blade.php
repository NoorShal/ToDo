@extends('layouts.master')
@section('content')

<div class="container  justify-content-center text-center">
    <div class="row justify-content-center m-4 text-center">
    <div class="col-4">
        <div class="row">
            <h3>
                <i class="fa fa-camera-retro"></i>

                To-do Tasks
            </h3>
        </div>
        <div class="row">
            <ol data-name="TO_DO" class="to-do-list-1 list-group list-group-flush"  style="overflow-y: auto">
                @foreach($tasks->where('status','TO_DO') as $task)
                 @include('components.list-item',['task' => $task])
                @endforeach
            </ol>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <h3>
                <i class="fa fa-spinner"></i>

                In Progress Tasks
            </h3>
        </div>
        <div class="row">
            <ol data-name="IN_PROGRESS" class="to-do-list-2 list-group list-group-flush"  style="overflow-y: auto">
                @foreach($tasks->where('status','IN_PROGRESS') as $task)
                    @include('components.list-item',['task' => $task])

                @endforeach
            </ol>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <h3>
                <i class="fa  fa-check-circle-o"></i>

                Done
            </h3>
        </div>
        <div class="row">
            <ol data-name="DONE" class="to-do-list-3 list-group list-group-flush" style="overflow-y: auto">
                @foreach($tasks->where('status','DONE') as $task)
                    @include('components.list-item',['task' => $task])

                @endforeach
            </ol>
        </div>
    </div>
    </div>
</div>

<a data-toggle="modal" data-target="#myModal" style="position:absolute;bottom:5px;right:5px;margin:0;padding:5px 3px;" href="#"><i class="fa fa-plus-circle fa-4x"></i></a>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">New Task</h1>
            </div>
            <div class="modal-body">
                <form id="task-form" role="form" method="POST" action="">
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label class="control-label">Task Title</label>
                        <div>
                            <input  type="text" class="form-control input-lg" name="title" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="exampleFormControlTextarea1" class="control-label">Description</label>
                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Due Date</label>

                        <div class="input-group date">
                            <input placeholder="pick a date" name="due_date" data-provide="datepicker">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@stop

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.to-do-list-1').sortable({
            group: 'shared',
            onDrop: function ($item, container, _super, event) {
                console.log($item.data().id);
                var data = {
                    status: container.el.data().name,
                    id: $item.data().id,
                }
                console.log(data)

                var url =  '{{url('task/update')}}'
                console.log(url);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,

                });
                _super($item, container);
            }

        });

        $('.to-do-list-2').sortable({
            group: 'shared',
            onDrop: function ($item, container, _super, event) {

                var data = {
                    status: container.el.data().name,
                    id: $item.data().id,

                }
                console.log(data)

                var url =  '{{url('task/update')}}'
                console.log(url);

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                });
                _super($item, container);
            }

        });

        $(' .to-do-list-3').sortable({
            group: 'shared',
            drag: false,


        });

        $('.delete').on('click',function (e) {

            var id = $(this).data().id;
            var data = {
                id: id,
            }

            var url =  '{{url('task/delete')}}'

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (response) {

                    if (response.code == 200){
                        $('.task-' + id).remove()
                    }
                }
            });
        })


        $('#task-form').submit(function (e) {

            e.preventDefault();
            var title = $(this).find("input[name=title]").val();
            var description = $(this).find("textarea[name=description]").val();
            var due_date = $(this).find("input[name=due_date]").data('datepicker').getFormattedDate('yyyy-mm-dd');
            var data = {
                title: title,
                description: description,
                due_date: due_date,
            }
            var url =  '{{url('task')}}'

            console.log(data);
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (response) {

                    if (response.code == 200){
                        let data = response.data;
                        $('.to-do-list-1').append(`
                            <li data-id="${data.id}" class="list-group-item task-${data.id}">
                        <div class="todo-indicator bg-success"></div>
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">

                                <div class="widget-content-left flex2">
                                    <div class="widget-heading">${data.title}</div>
                                    <div class="widget-subheading "><small>${data.description}</small></div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="widget-content-right">  <button data-id="${data.id}" class="border-0 btn-transition btn btn-outline-danger delete"> <i class="fa fa-trash"></i> </button> </div>
                                    </div>
                                    <div class="col-8"><small class="text-muted">${data.due_date}</small></div>
                                </div>
                            </div>
                        </div>
                    </li>
                        `)
                    }
                    $("#myModal").modal("hide");

                }

            });

        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush
