<li data-id="{{$task->id}}" class="list-group-item task-{{$task->id}}">
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">

            <div class="widget-content-left flex2">
                <div class="widget-heading">{{$task->title}}</div>
                <div class="widget-subheading "><small>{{$task->description}}</small></div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="widget-content-right">  <button data-id="{{$task->id}}" class="border-0 btn-transition btn btn-outline-danger delete"> <i class="fa fa-trash"></i> </button> </div>
                </div>
                @if ($task->status != 'DONE')
                    <div class="col-8"><small class="text-muted">{{$task->due_date}}</small></div>
                @else
                    <div class="col-8"><small class="text-muted">{{$task->complete_date}}</small></div>
                @endif
            </div>
        </div>
    </div>
</li>
